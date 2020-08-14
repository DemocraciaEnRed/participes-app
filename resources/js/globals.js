const globals = {
  methods: {
    getReportIcon: function(type){
      switch(type){
        case 'post':
          return 'fa-bullhorn'
          break;
        case 'progress':
          return 'fa-fast-forward'
          break;
        case 'milestone':
          return 'fa-medal'
          break;
        default:
          return 'fa-file'
      }
      return 'fa-question-circle'
    },
     shortString: function(text, limit) {
      if (text.length > limit) {
        for (let i = limit; i > 0; i--) {
          if (
            text.charAt(i) === " " &&
            (text.charAt(i - 1) != "," ||
              text.charAt(i - 1) != "." ||
              text.charAt(i - 1) != ";")
          ) {
            return text.substring(0, i) + "[...]";
          }
        }
      } else {
        return text;
      }
    },
  }
}

export default globals