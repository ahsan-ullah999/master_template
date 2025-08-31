const postcssConfig = {
  map: {
    inline: false,
    annotation: true,
    sourcesContent: true
  },
  plugins: {
    //     tailwindcss: {},
    //     autoprefixer: {},
    // ...(process.env.NODE_ENV === 'RTL' ? { rtlcss: {} } : {}),
    // autoprefixer: {
    //   cascade: false
    // }
  }
}

export default postcssConfig
