<template>
  <div class="col-span-12 flex flex-col gap-3">
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
        Upload
      </button>
    </form>
    <div class="flex flex-col gap-3">
      <div class="col-span-12 flex flex-col divide-y card">
        <div class="grid grid-cols-12 px-6 py-3 text-black font-medium bg-black  bg-opacity-5 rounded">
          <div class="col-span-1">
            ID
          </div>
          <div class="col-span-7">
            Name
          </div>
          <div class="col-span-2">
            Result
          </div>
          <div class="col-span-2">
            File
          </div>
        </div>
        <div class="p-3">
          <div
            v-for="file in files"
            :key="file.id"
            class="grid grid-cols-12 p-3"
          >
            <div class="col-span-1">
              {{ file.id }}
            </div>
            <div class="col-span-7">
              {{ file.filename }}
            </div>
            <div class="col-span-2">
              {{ file.result }}
            </div>
            <div class="col-span-2">
              {{ file.file_id }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import uploadApi from '../../api/upload.js';

const MAX_FILE = 10;
const REFRESH_RATE = 1000; // [ms]

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
      files: [],
    };
  },
  methods: {
    async send() {
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
          }).then(data => {
            this.files.push(...data.data.upload_files);
            setTimeout(() => this.refreshFiles(data.data.id), REFRESH_RATE);
          });

          this.sendedFiles = i + 1;

          newForm.delete('files[]');
        }
      });
    },
    async refreshFiles(id) {
      const upload = (await uploadApi.getUpload(id)).data;
      let shouldRefreshAgain = false;
      upload.uploadFiles.forEach(file => {
        const i = this.files.findIndex(obj => obj.id === file.id);

        this.$set(this.files, i, file);

        if (!shouldRefreshAgain && file.result !== 'replaced' && file.result !== 'stored') {
          shouldRefreshAgain = true;
        }
      }, this);

      if (shouldRefreshAgain) {
        setTimeout(() => this.refreshFiles(id), REFRESH_RATE);
      }
    },
  },
};
</script>
