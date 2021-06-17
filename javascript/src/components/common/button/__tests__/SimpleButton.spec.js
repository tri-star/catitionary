import { mount } from '@vue/test-utils'
import SimpleButton from '../SimpleButton'

describe('SimpleButton', () => {
  const createWrapper = (title) => {
    return mount(SimpleButton, {
      propsData: {
        title,
      },
    })
  }

  it('指定したタイトルが表示されていること', () => {
    const buttonTitle = 'testTitle'
    const wrapper = createWrapper(buttonTitle)

    expect(wrapper.text()).toMatch(new RegExp(buttonTitle))
  })
  it('クリックするとイベントが発行されること', async () => {
    const buttonTitle = 'testTitle'
    const wrapper = createWrapper(buttonTitle)
    await wrapper.trigger('click')

    expect(wrapper.emitted('onclick')).toBeTruthy()
  })
})
