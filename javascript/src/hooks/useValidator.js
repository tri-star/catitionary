import { ValidationResult, Validator } from '@/lib/validator/Validator'
import { reactive } from '@vue/composition-api'

export const useValidator = () => {
  const state = reactive({
    errors: {},
  })
  const validator = new Validator()
  let result = new ValidationResult()

  const setInitialData = (initialData) => {
    validator.setInitialData(initialData)
  }

  const updateErrors = (newErrors) => {
    state.errors = {}
    for (const field in newErrors) {
      if (state.errors[field] === undefined) {
        state.errors[field] = []
      }
      for (const i in newErrors[field]) {
        state.errors[field].push(newErrors[field][i])
      }
    }
  }

  const validate = async (input, ruleCollection, force = false, context) => {
    result = await validator.validate(input, ruleCollection, force, context)
    updateErrors(result.getAll())
  }

  const isError = () => {
    return result.isError()
  }

  const hasError = (field) => {
    return result.hasError(field)
  }

  const getErrors = () => {
    return state.errors
  }

  const getMessages = (field) => {
    return result.getMessages(field)
  }

  const getMessage = (field) => {
    const messages = result.getMessages(field)
    return messages.length > 0 ? messages[0] : ''
  }

  return {
    state,
    setInitialData,
    validate,
    isError,
    hasError,
    getMessages,
    getMessage,
    getErrors,
  }
}
