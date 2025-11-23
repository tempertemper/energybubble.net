import smartypants from "smartypants";
import uslug from "uslug";
import markdownIt from "markdown-it";
import anchor from "markdown-it-anchor";
import slugify from "slugify";
import pluginRss from "@11ty/eleventy-plugin-rss";
import dateFilter from "./lib/filters/dates.js";

export default function(eleventyConfig) {

  /* Date filter */
  eleventyConfig.addFilter("date", dateFilter);

  /* Data */
  eleventyConfig.setDataDeepMerge(true);

  /* Smart quotes filter */
  eleventyConfig.addFilter("smart", function (str) {
    return smartypants(str);
  });

  /* Markdown Plugins */
  const uslugify = s => uslug(s);
  const mdIntro = markdownIt({
    typographer: true
  });

  eleventyConfig.setLibrary(
    "md",
    markdownIt({
      html: true,
      typographer: true
    }).use(anchor, { slugify: uslugify, tabIndex: false })
  );

  eleventyConfig.addFilter("markdown", function (markdown) {
    return mdIntro.render(markdown);
  });

  eleventyConfig.addFilter("twitterLink", function (str) {
    return "https://twitter.com/" + str.replace("@", "");
  });

  eleventyConfig.addFilter("slug", function (str) {
    return slugify(str, {
      replacement: "-",
      remove: /[*+~.,–—()'"‘’“"!?:;@]/g,
      lower: true
    });
  });

  /* RSS */
  eleventyConfig.addPlugin(pluginRss);

  /* List all tags */
  eleventyConfig.addFilter("tags", function (collection) {
    const notRendered = ["all", "post", "resource", "testimonial"];
    return Object.keys(collection)
      .filter(d => !notRendered.includes(d))
      .sort();
  });

  /* List tags belonging to a page */
  eleventyConfig.addFilter("tagsOnPage", function (tags) {
    const notRendered = ["all", "post", "resource", "testimonial"];
    return tags
      .filter(d => !notRendered.includes(d))
      .sort();
  });

  eleventyConfig.addFilter("getCurrentYear", function () {
    return new Date().getFullYear();
  });

  // Passthroughs
  eleventyConfig.addPassthroughCopy({ "src/img": "assets/img" });

  // Localhost server config
  eleventyConfig.setServerOptions({
    port: 3000
  });

  return {
    dir: {
      input: "src/site",
      output: "dist",
      includes: "_includes",
      layouts: "_layouts"
    },
    templateFormats: ["njk", "html", "md", "txt", "webmanifest", "ico"],
    htmlTemplateEngine: "njk",
    markdownTemplateEngine: "njk"
  };
}
