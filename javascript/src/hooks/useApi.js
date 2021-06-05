import { reactive } from '@vue/composition-api'
import { ApiError } from '@/errors/ApiError'
import { AxiosError } from 'axios'

export const useApi = (asyncFunction) => {
  const state = reactive({
    isPending: false,
    isError: false,
    error: null,
  })

  const execute = async () => {
    state.isPending = true
    return await asyncFunction()
      .then((response) => {
        state.error = null
        state.isError = false
        return response
      })
      .catch((error) => {
        if (error instanceof AxiosError) {
          state.error = new ApiError(error.message, error.code)
          state.isError = true
          return null
        }
        if (error instanceof Error) {
          state.error = new ApiError(error.message)
          state.isError = true
          return null
        }
      })
      .finally(() => {
        state.isPending = false
      })
  }

  const isPending = () => {
    return state.isPending
  }
  const isDone = () => {
    return !state.isPending && !state.isError
  }
  const isError = () => {
    return !state.isPending && state.isError
  }

  return {
    isPending,
    isDone,
    isError,
    execute,
  }
}
