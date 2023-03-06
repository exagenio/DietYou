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
protein_gram <- gsub("[^0-9.]", "", 
                     tolower(gsub(",", "", regmatches(text, regexpr("\\bprotein.*[0-9] g", tolower(text))))[1]))

# Print the extracted gram value
print(paste("The gram value in front of the word protein is:", protein_gram))

# Extract the gram value in front of the word "carbohydrates"
carbohydrates_gram <- gsub("[^0-9.]", "", 
                           tolower(gsub(",", "", regmatches(text, regexpr("\\bcarbohydrates.*[0-9] g", tolower(text))))[1]))

# Print the extracted gram value
print(paste("The gram value in front of the word Carbohydrates is:", carbohydrates_gram))

# Extract the gram value in front of the word "fats"
fats_gram <- gsub("[^0-9.]", "", 
                           tolower(gsub(",", "", regmatches(text, regexpr("\\total fat.*[0-9] g", tolower(text))))[1]))

# Print the extracted gram value
print(paste("The gram value in front of the word Fats is:", fats_gram))

