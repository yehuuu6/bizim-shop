const path = require("path");

module.exports = {
  watch: true,
  mode: "development",
  entry: {
    a578a8g: path.resolve(__dirname, "src/auth/auth.js"),
    dr52j2s: path.resolve(__dirname, "src/dashboard/routing.js"),
    du48gn1: path.resolve(__dirname, "src/dashboard/user.js"),
    da48gn2: path.resolve(__dirname, "src/dashboard/dev.js"),
  },
  output: {
    path: path.resolve(__dirname, "dist"),
    filename: "[name].js",
  },
};
