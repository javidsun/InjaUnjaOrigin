
const errorMap = {
  400: { message: 'Bad Request', color: 'orange' },
  401: { message: 'Unauthorized', color: 'red' },
  403: { message: 'Forbidden', color: 'red' },
  404: { message: 'Not Found', color: 'gray' },
  405: { message: 'Method Not Allowed', color: 'darkorange' },
  408: { message: 'Request Timeout', color: 'lightcoral' },
  409: { message: 'Conflict', color: 'orange' },
  422: { message: 'Unprocessable Entity', color: 'purple' },
  429: { message: 'Too Many Requests', color: 'tomato' },
  500: { message: 'Internal Server Error', color: 'red' },
  501: { message: 'Not Implemented', color: 'darkred' },
  502: { message: 'Bad Gateway', color: 'orangered' },
  503: { message: 'Service Unavailable', color: 'lightgray' },
  504: { message: 'Gateway Timeout', color: 'darkgray' },
  default: { message: 'Unexpected error occurred', color: 'black' },
};

export default {
  getErrorMessage(status) {
    return errorMap[status]?.message || errorMap.default.message;
  },

  getErrorColor(status) {
    return errorMap[status]?.color || errorMap.default.color;
  },

  handleError(exception) {
    const status = exception?.response?.status || 'default';
    return {
      message: this.getErrorMessage(status),
      color: this.getErrorColor(status),
    };
  },
};
