const handleSuccess = (res, cb, error) => {
    if(res.data.success === true) {
        cb(res.data);
        return;
    }

    this.common_error = res.data.error;
};
