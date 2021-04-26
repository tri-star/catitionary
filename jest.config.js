module.exports = {
  moduleNameMapper: {
    '^@/(.*)$': '<rootDir>/javascript/src/$1',
    '^~/(.*)$': '<rootDir>/javascript/src/$1',
    '^vue$': 'vue/dist/vue.common.js',
  },
  moduleFileExtensions: ['js', 'json'],
  transform: {
    '^.+\\.js$': 'babel-jest',
    '.*\\.(vue)$': 'vue-jest',
  },
  collectCoverage: true,
  collectCoverageFrom: ['<rootDir>/javascript/src/**/*.vue'],
  // setupFiles: ['./test/setup.js'],
}
