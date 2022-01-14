<template>
  <form
    id="form-files"
    action="/admin/files"
    method="POST"
    class="col-span-12 flex flex-col gap-3"
    enctype="multipart/form-data"
  >
    <input
      type="text"
      name="_token"
      :value="csrf"
      hidden
    >
    <div class="grid grid-cols-12 gap-3">
      <input
        class="col-start-5 col-span-6"
        type="file"
        name="files[]"
        multiple
      >
    </div>
    <div class="grid grid-cols-12 gap-3">
      <span class="col-start-5 col-span-2">Parent collection: </span>
      <select
        class="col-span-2 rounded"
        name="data[collection_id]"
      >
        <option
          v-for="collection in collections"
          :key="collection.id"
          :value="collection.id"
        >
          {{ collection.name }}
        </option>
      </select>
    </div>
    <button
      type="button"
      @click="send"
      class="bg-indigo-800 rounded p-3 text-white w-96 mx-auto"
    >
      Upload ({{ sendedFiles }}/{{ totalFiles }})
    </button>
  </form>
</template>

<script>
import axios from 'axios';

const MAX_FILE = 10;

export default {
  props: {
    collections: {
      type: Array,
      required: true,
    },
    csrf: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      totalFiles: null,
      sendedFiles: null,
    };
  },
  methods: {
    send() {
      const files = (new FormData(document.getElementById('form-files'))).getAll('files[]');

      this.totalFiles = files.length;
      this.sendedFiles = 0;

      const newForm = new FormData(document.getElementById('form-files'));
      newForm.delete('files[]');

      files.forEach((file, i) => {
        newForm.append('files[]', file);
        if (i % MAX_FILE === 0 || i === this.totalFiles - 1) {
          axios({
            method: 'post',
            url: '/admin/files',
            data: newForm,
          });

          this.sendedFiles = i + 1;

          newForm.delete('files[]');
        }
      });
    },
  },
};
</script>
