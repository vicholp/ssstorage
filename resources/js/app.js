import Vue from 'vue';

document.addEventListener('DOMContentLoaded', () => {
  if (document.getElementById('app') !== null) {
    const app = new Vue({
      el: '#app',
    });

    return app;
  }

  return false;
});
