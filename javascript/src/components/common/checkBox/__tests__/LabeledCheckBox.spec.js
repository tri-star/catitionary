import { mount } from '@vue/test-utils'
import LabeledCheckBox from '../LabeledCheckBox'

describe('LabeledCheckBox', () => {
  const createWrapper = (id, label, checked = false) => {
    return mount(LabeledCheckBox, {
      propsData: {
        id,
        label,
        checked,
      },
    })
  }

  it('ラベル名が表示されること', () => {
    const expectedLabel = 'テスト'
    const wrapper = createWrapper('test', expectedLabel)
    expect(wrapper.text()).toBe(expectedLabel)
  })

  it('初期状態でチェック済の要素が作成できること', () => {
    const wrapper = createWrapper('test', 'テスト', true)
    expect(wrapper.find('input[type="checkbox"]').element.checked).toBeTruthy()
  })

  it('クリックすると状態とidを通知すること', async () => {
    const wrapper = createWrapper('test', 'テスト', true)
    await wrapper.find('input[type="checkbox"]').setChecked(false)

    expect(wrapper.emitted('check')[0]).toStrictEqual([
      {
        id: 'test',
        checked: false,
      },
    ])
  })
})
