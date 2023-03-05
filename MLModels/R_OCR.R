install.packages("tesseract")
install.packages("imager")

library(png)
library(tidyverse)
library(imager)
library(tesseract)

img <- "R.png"

text <- ocr(img)

# identifying the words e.g- protein
protein_regex <- "Protein"
#changed kcal to gram
protein_gram_regex <- "([0-9]+\\.[0-9]+) g"
protein_kcal_value <- NA

#changed grep1 to grepl

if (grepl(protein_regex, text)) {
  protein_line <- regexpr(protein_regex, text)
  protein_line_end <- regexpr("\n", text[protein_line:length:length(text)]) + protein_line - 1
  protein_line_text <- substr(text, protein_line, protein_line_end)
  
  # identfying the kcal value of protein and storing it in a variable
  #changed grep to grepl
  if (grepl(protein_gram_regex, protein_line_text)) {
    protein_gram_match <- regmatches(protein_line_text, regexpr(protein_gram_regex, protein_line_text))
    protein_gram_value <- as.numeric(gsub(" g", "", protein_gram_match))
  }
}
#added print function 
print(protein_gram_value)