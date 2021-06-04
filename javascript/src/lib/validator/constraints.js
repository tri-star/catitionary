const isString = (value) => {
  if (value === undefined || value === null) {
    return false
  } else if (typeof value === 'string' || typeof value === 'number') {
    return true
  }
  return false
}

export const constraints = {
  required: () => {
    return (value, parameters, input, context) => {
      const okResponse = {
        ok: true,
      }
      const errorResponse = {
        ok: false,
        message: '必ず入力してください',
      }
      if (!isString(value)) {
        return errorResponse
      }

      if (String(value) === '') {
        return errorResponse
      }
      return okResponse
    }
  },
  length: (min, max) => {
    return (value, parameters, input, context) => {
      const okResponse = {
        ok: true,
      }
      const errorResponse = {
        ok: false,
        message: `${min}文字以上${max}文字以内で入力してください`,
      }
      if (!isString(value)) {
        return errorResponse
      }

      const len = String(value).length
      if (len < min || len > max) {
        return errorResponse
      }
      return okResponse
    }
  },

  maxLength: (max) => {
    return (value, parameters, input, context) => {
      const okResponse = {
        ok: true,
      }
      const errorResponse = {
        ok: false,
        message: `${max}文字以内で入力してください`,
      }
      if (!isString(value)) {
        return errorResponse
      }

      const len = String(value).length
      if (len > max) {
        return errorResponse
      }
      return okResponse
    }
  },
  betweenLength: (min, max) => {
    return (value, parameters, input, context) => {
      const okResponse = {
        ok: true,
      }
      const errorResponse = {
        ok: false,
        message: `${min}文字以上${max}文字以内で入力してください`,
      }
      if (!isString(value)) {
        return errorResponse
      }

      const len = String(value).length
      if (len < min || len > max) {
        return errorResponse
      }
      return okResponse
    }
  },
  same: (field, displayName) => {
    return (value, parameters, input, context) => {
      const okResponse = {
        ok: true,
      }
      const errorResponse = {
        ok: false,
        message: `${displayName}と内容が一致していません`,
      }
      if (value !== input[field]) {
        return errorResponse
      }
      return okResponse
    }
  },
}
