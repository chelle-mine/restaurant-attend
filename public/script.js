'use strict';

document.addEventListener('DOMContentLoaded', () => {
  document.querySelector('form').addEventListener('submit', getRestaurants);
});

/*
 * Event triggered by btn.get-reviews
 * Fetches reviews and populates DOM element
 * Send request to 'get_reviews.php'
 * @param {string} business `business_id` from Yelp API 
 * @return {JSON}
 */
function getReviews() {
  const elem = this;

  // hide any visible review divs
  let divs;
  if (divs = document.querySelector('.reviews-visible')) {
    divs.classList.remove('reviews-visible');
    divs.classList.add('reviews-hidden');
  }

  // make ajax request
  const param = 'business_id=' + elem.parentNode.id;
  getRequest('GET', 'get_reviews.php?' + param, function(results) {
    fetchReviews(JSON.parse(results).reviews);
    elem.addEventListener('click', displayReviews);
  })

  // find existing div.reviews and display it
  function displayReviews() {
    // hide any visible review divs
    let divs;
    if (divs = document.querySelector('.reviews-visible')) {
      divs.classList.remove('reviews-visible');
      divs.classList.add('reviews-hidden');
    }
    const div = document.getElementById('reviews-' + this.parentNode.id);
    div.classList.remove('reviews-hidden');
    div.classList.add('reviews-visible');
  }

  // called within AJAX request;
  // create displays for results
  function fetchReviews(revs) {

    const div = document.createElement('div');
    div.classList.value = 'reviews reviews-visible';
    div.id = 'reviews-' + elem.parentNode.id;
    for (let i = 0; i < revs.length; i++) {
      const p = document.createElement('p');
      p.innerText = revs[i].rating + ': ' + revs[i].text;
      div.appendChild(p);
    }
    elem.parentNode.appendChild(div);
  }
}

/*
 * Send request to 'get_restaurants.php'
 * Fetch restaurants in user-provided location
 * Display fetched data in new divs
 */
function getRestaurants(e) {
  e.preventDefault();
  // clear results from previous search
  document.getElementById('results').innerHTML = '';
  const params = 'location=' + this['user-location'].value;
  getRequest('GET', '/get_restaurants.php?' + params, function(results) {
    const businesses = JSON.parse(results).businesses;
    for (let i = 0; i < businesses.length; i++) {
      displayRestaurant(businesses[i]);
    }
  });

  /*
   * Create a div with `image_url`, `name`, `location.display_address`,
   * `price`, `rating` and `review_count`, `url`
   * Children: <button class="btn get-reviews">
   *           <button class="btn going">
   */
  function displayRestaurant(obj) {
    const li = document.createElement('li');
    li.classList.value = 'ul-item result';

    const div = document.createElement('div');
    div.classList.value = 'li-item result-div';
    div.id = obj.id;
    div.innerText = obj.name + ' ' + obj.review_count;
    
    const reviewsBtn = document.createElement('button');
    reviewsBtn.classList.value = 'btn get-reviews';
    reviewsBtn.innerText = 'See reviews';
    reviewsBtn.addEventListener('click', getReviews, { once: true });

    const goingBtn = document.createElement('button');
    goingBtn.classList.value = 'btn going';
    goingBtn.addEventListener('click', updateDb);

    div.appendChild(reviewsBtn);
    div.appendChild(goingBtn);
    li.appendChild(div);
    document.getElementById('results').appendChild(li);
  }
}

/*
 * Check table `restaurants` for `restaurant_id`
 * found
 * ? display `attending`
 * : display 0
 */
function queryDb(restaurant_id) {
}

function updateDb() {
  // increment or decrement db entry
  if (this.classList.contains('going')) {
    /*
     * Check table `restaurants` for `restaurant_id`
     * found
     * ? increment `.attending` add user to `users_restaurants`
     * : increment `.attending` add restaurant to `restaurants` and users to `users_restaurants`
     */
  } else if (this.classList.contains('not-going')) {

  }
}
