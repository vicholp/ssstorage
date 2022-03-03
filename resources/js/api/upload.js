import api from './index';

export default {
  getUpload(id) {
    return api({
      method: 'get',
      url: `/admin/uploads/${id}`,
    });
  },
};
