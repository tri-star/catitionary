module.exports = {
  presets: [
    ['@babel/preset-env', { targets: '> 1%, last 2 versions, not dead' }],
    '@vue/cli-plugin-babel/preset',
  ],
  plugins: [
    [
      'inline-dotenv',
      {
        path: './.env',
      },
    ],
  ],
}
