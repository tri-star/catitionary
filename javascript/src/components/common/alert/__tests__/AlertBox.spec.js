import { mount } from '@vue/test-utils'
import AlertBox from '../AlertBox'

describe('AlertBox', () => {
  const createWrapper = (message, visible) => {
    return mount(AlertBox, {
      propsData: {
        message,
        visible,
      },
    })
  }

  describe('visible', () => {
    it('trueの場合はメッセージを表示する', () => {
      const testMessage = 'testMessage'
      const wrapper = createWrapper(testMessage, true)

      expect(wrapper.text()).toMatch(new RegExp(testMessage))
    })
    it('falseの場合はメッセージを表示しない', () => {
      const testMessage = 'testMessage'
      const wrapper = createWrapper(testMessage, false)
      expect(wrapper.text()).not.toMatch(new RegExp(testMessage))
    })
  })
})
