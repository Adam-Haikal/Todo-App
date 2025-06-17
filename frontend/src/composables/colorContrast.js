import contrast from "color-contrast";

/* Get text color based on background color */
export function colorContrast(backgroundColor) {
  const textColor = "#fff";
  const contrastRatio = contrast(backgroundColor, textColor);
  /* threshold for readable contrast */
  if (contrastRatio < 4.5) {
    return "#000"; /* change text color to black if contrast is too low */
  }
  return textColor;
}
