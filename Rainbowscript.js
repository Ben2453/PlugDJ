var s = document.createElement('style')
s.textContent = `
  @keyframes rainbows {
    from { filter: hue-rotate(0deg); -webkit-filter: hue-rotate(0deg) }
    to   { filter: hue-rotate(360deg); -webkit-filter: hue-rotate(360deg) }
  }
  body {
    animation: 2s linear 0s infinite rainbows;
  }
`;
document.body.appendChild(s)
