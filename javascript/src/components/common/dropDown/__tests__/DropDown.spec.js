import { mount } from '@vue/test-utils'
import DropDown from '../DropDown'

describe('DropDown', () => {
  const createWrapper = (show, slot) => {
    return mount(DropDown, {
      propsData: {
        show,
      },
      slots: {
        default: slot,
      },
    })
  }

  describe('show', () => {
    it('trueの時、内部要素が表示されること', () => {
      const innerItem = document.createElement('p')
      innerItem.textContent = 'test'
      const wrapper = createWrapper(true, innerItem.outerHTML)

      expect(wrapper.text()).toMatch(new RegExp('test'))
    })

    it('trueの時、背景にマスクが表示されていること', () => {
      const innerItem = document.createElement('p')
      innerItem.textContent = 'test'
      const wrapper = createWrapper(true, innerItem.outerHTML)

      expect(wrapper.find('[data-test="mask"]').isVisible()).toBeTruthy()
    })

    it('falseの時、内部要素は表示されないこと', async () => {
      const innerItem = document.createElement('p')
      innerItem.textContent = 'test'
      const wrapper = createWrapper(false, innerItem.outerHTML)

      expect(wrapper.text()).not.toMatch(new RegExp('test'))
    })

    it('falseの時、背景にマスクが表示されていないこと', () => {
      const innerItem = document.createElement('p')
      innerItem.textContent = 'test'
      const wrapper = createWrapper(false, innerItem.outerHTML)

      expect(wrapper.find('[data-test="mask"]').exists()).toBeFalsy()
    })
  })
})
