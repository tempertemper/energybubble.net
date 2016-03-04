module.exports = {
  fonts: {
    expand: true,
    cwd: 'dev/fonts/',
    src: '**',
    dest: 'web/cms/addons/feathers/energybubble/fonts/',
  },
  favicon: {
    expand: true,
    cwd: 'dev/images/icons/',
    src: 'favicon.ico',
    dest: 'web/cms/addons/feathers/energybubble/img/icons',
  },
  js: {
    expand: true,
    flatten: true,
    src: [
      'dev/components/responsive-nav/responsive-nav.min.js',
      'dev/components/html5shiv/dist/html5shiv.min.js'
    ],
    dest: 'web/cms/addons/feathers/energybubble/js/',
  }
}