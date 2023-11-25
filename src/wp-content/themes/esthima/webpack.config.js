const path = require("path");
const { VueLoaderPlugin } = require('vue-loader')


const args = (argList => {
  let arg = {}, a, opt, thisOpt, curOpt;
  for (a = 0; a < argList.length; a++) {
    thisOpt = argList[a].trim();
    opt = thisOpt.replace(/^\-+/, '');
    if (opt === thisOpt) {
      // argument value
      if (curOpt) arg[curOpt] = opt;
      curOpt = null;
    }
    else {
      // argument name
      curOpt = opt;
      arg[curOpt] = true;
    }
  }
  return arg;
})(process.argv);



const config = {
  entry:
  {
    global: "./src/js/global.js",
    petsConfigurator: "./src/js/petsConfigurator/src/main.js",
    trackingEvents: "./src/js/trackingEvents.js",
    trackingDataLayer: "./src/js/trackingDataLayer.js",
    tracking: "./src/js/tracking.js"
  },
  mode: (args.env == 'production') ? "production" : "development",
  target: ["web", "es5"],
  resolve: {
    extensions: ["*", ".js", ".vue"]
  },
  module: {
    rules: [
      {
        exclude: /node_modules/,
        test: /\.(js|jsx)$/i,
        use: {
          loader: 'babel-loader',
        }
      },
      {
        test: /\.vue$/,
        use: {
          loader: 'vue-loader',
        }
      }
    ]
  },
  output: {
    filename: '[name].js',
    path: path.resolve(__dirname),
  },
  plugins: [
    new VueLoaderPlugin()
  ]
};

module.exports = config;
