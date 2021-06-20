module.exports = {
  moduleNameMapper: {
    '^@/(.*)$': '<rootDir>/javascript/src/$1',
    '^~/(.*)$': '<rootDir>/javascript/src/$1',
    '^vue$': 'vue/dist/vue.common.js',
  },
  moduleFileExtensions: ['js', 'json', 'vue'],
  transform: {
    '^.+\\.js$': 'babel-jest',
    '.*\\.(vue)$': 'vue-jest',
  },
  collectCoverage: true,
  coverageDirectory: 'tests/coverage/jest',
  collectCoverageFrom: ['<rootDir>/javascript/src/**/*.{js,vue}'],
  coverageReporters: ['html-spa', 'text-summary', 'lcov'],
  setupFiles: ['./javascript/src/bootstrap_test.js'],
}
