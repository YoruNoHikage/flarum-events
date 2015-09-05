var gulp = require('flarum-gulp');

gulp({
  modules: {
    'events': [
      '../lib/**/*.js',
      'src/**/*.js'
    ]
  }
});
