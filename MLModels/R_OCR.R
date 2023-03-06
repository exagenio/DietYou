install.packages("tesseract")
install.packages("magick")

library(magick)
library(tesseract)

dfo <- image_read("calorie_table.png")

dfo_processed <- dfo %>%
  image_convert(type = 'Grayscale') %>%
  image_trim(fuzz = 40) %>%
  image_write(format = 'png', density= '300x300') %>%

text <- tesseract::ocr(dfo_processed)

# Extract the gram value in front of the word "protein"
protein_gram <- NULL
for (i in seq_along(text)) {
  if (grepl("protein", tolower(text[i]))) {
    protein_gram <- gsub("[^0-9.]", "", tolower(text[i+1]))
    break
  }
}
protein_gram

# Print the extracted gram value
if (!is.null(protein_gram)) {
  print(paste("The gram value in front of the word protein is:", protein_gram))
} else {
  print("The word protein was not found in the extracted text.")
}

# Extract the gram value in front of the word "Carbohydrates"
carbohydrate_gram <- NULL
for (i in seq_along(text)) {
  if (grepl("carbohydrates", tolower(text[i]))) {
    carbohydrate_gram <- gsub("[^0-9.]", "", tolower(text[i+1]))
    break
  }
}
carbohydrate_gram

# Print the extracted gram value
if (!is.null(carbohydrate_gram)) {
  print(paste("The gram value in front of the word Carbohydrates is:", carbohydrate_gram))
} else {
  print("The word Carbohydrates was not found in the extracted text.")
}

# Extract the gram value in front of the word "Fat, Total"
fats_gram <- NULL
for (i in seq_along(text)) {
  if (grepl("fat, total", tolower(text[i]))) {
    fats_gram <- gsub("[^0-9.]", "", tolower(text[i+1]))
    break
  }
}
fats_gram

# Print the extracted gram value
if (!is.null(fats_gram)) {
  print(paste("The gram value in front of the word Fat is:", fats_gram))
} else {
  print("The word Fat was not found in the extracted text.")
}