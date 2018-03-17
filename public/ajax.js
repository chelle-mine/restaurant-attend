'use strict';

function getRequest(method, url, cb) {
  const xhr = new XMLHttpRequest();

  xhr.addEventListener('load', () => {
    return cb(xhr.responseText);
  });

  xhr.addEventListener('error', () => {
    return JSON.stringify('Request failed.');
  });
  
  xhr.open(method, url, true);
  xhr.send();
}
