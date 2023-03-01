install.packages("tesseract")
install.packages("imager")

library(imager)
library(tesseract)

img <- load.image("calorie_table.png")

# Pre-process the image to improve OCR accuracy
img <- grayscale(img)
img <- threshold(img, "binarize")

text <- ocr(img)


# identifying the words e.g- protein
protein_regex <- "Protein"
protein_kcal_regex <- "([0-9]+\\.[0-9]+) g"
protein_kcal_value <- NA

if (grep1(protein_regex, text)) {
  protein_line <- regexpr(protein_regex, text)
  protein_line_end <- regexpr("\n", text[protein_line:length:length(text)]) + protein_line - 1
  protein_line_text <- substr(text, protein_line, protein_line_end)
  
  # identfying the kcal value of protein and storing it in a variable
  if (grep(protein_gram_regex, protein_line_text)) {
    protein_gram_match <- regmatches(protein_line_text, regexpr(protein_gram_regex, protein_line_text))
    protein_gram_value <- as.numeric(gsub(" g", "", protein_gram_match))
  }
}