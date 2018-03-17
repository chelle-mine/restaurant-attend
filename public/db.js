'use strict';

function dbRequest(method, url, cb) {
  const xhr = new XMLHttpRequest();
  xhr.addEventListener('load', () => {
    return cb(xhr.responseText);
  });
}
