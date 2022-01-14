import Vue from 'vue';

import FilesUpload from './components/files/upload.vue';

document.addEventListener('DOMContentLoaded', () => {
  if (document.getElementById('app') !== null) {
    Vue.component('FileUpload', FilesUpload);

    const app = new Vue({
      el: '#app',
    });

    return app;
  }

  return false;
});
