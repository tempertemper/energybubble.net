module.exports = function(eleventyConfig) {

  /* Date filter */
  eleventyConfig.addFilter("date", require("./lib/filters/dates.js") );

  /* Data */
  eleventyConfig.setDataDeepMerge(true);

  /* Smart quotes filter */
  const smartypants = require("smartypants");
  eleventyConfig.addFilter("smart", function(str) {
    return smartypants.smartypants(str, 'qDe');
  });

  /* Markdown Plugins */
  var uslug = require('uslug');
  var uslugify = s => uslug(s);
  var anchor = require('markdown-it-anchor');
  var markdownIt = require("markdown-it");
  eleventyConfig.setLibrary("md", markdownIt({
    html: true,
    typographer: true
  }).use(anchor, {slugify: uslugify, tabIndex: false}));
  var mdIntro = markdownIt({
    typographer: true
  });
  eleventyConfig.addFilter("markdown", function(markdown) {
    return mdIntro.render(markdown);
  });

  eleventyConfig.addFilter("twitterLink", function(str) {
    return "https://twitter.com/" + str.replace("@", "");
  });

  const slugify = require("slugify");
  eleventyConfig.addFilter("slug", function(str) {
    return slugify(str, {
      replacement: "-",
      remove: /[*+~.,–—()'"‘’“”!?:;@]/g,
      lower: true
    });
  });

  /* RSS */
  const pluginRss = require("@11ty/eleventy-plugin-rss");
  eleventyConfig.addPlugin(pluginRss);

  /* List all tags */
  eleventyConfig.addFilter("tags", function(collection) {
    const notRendered = ['all', 'post', 'resource', 'testimonial'];
    return Object.keys(collection)
      .filter(d => !notRendered.includes(d))
      .sort();
  });

  /* List tags belonging to a page */
  eleventyConfig.addFilter("tagsOnPage", function(tags) {
    const notRendered = ['all', 'post', 'resource', 'testimonial'];
    return tags
      .filter(d => !notRendered.includes(d))
      .sort();
  });

  eleventyConfig.addFilter("getCurrentYear", function() {
    return new Date().getFullYear();
  });

  // Localhost server config
  eleventyConfig.setServerOptions({
    port: 3000,
  });

  return {
    dir: {
      input: "src/site",
      output: "dist",
      includes: "_includes",
      layouts: "_layouts"
    },
    templateFormats : ["njk", "html", "md", "txt", "webmanifest", "ico"],
    htmlTemplateEngine : "njk",
    markdownTemplateEngine : "njk"
  };
};
