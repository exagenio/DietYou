library(tesseract)
library(magick)
library(stringr)

img <- image_read("calorie_table.png")

img_processed <- image_resize(img, "1000x")
img_processed <- image_contrast(img_processed)
img_processed <- image_convert(img_processed, "gray")
img_processed

text <- ocr(img_processed)

lines <- str_split(text, "\n")
lines

# Finding the line with either of the words "Energy" or "Calories"
energy_line_index <- grep("Energy|Calories", lines)

# Extracting the energy or calorie values from the line
energy_str <- lines[[energy_line_index]]
energy_vals <- ifelse(grepl("Energy", energy_str), 
                      str_extract(energy_str, "(?<=Energy\\s)[0-9]+"),
                      str_extract(energy_str, "(?<=Calories\\s)[0-9]+"))
energy_vals_numeric <- as.numeric(energy_vals)
energy_vals_numeric

energy_vals_no_na <- na.omit(energy_vals_numeric)
energy_vals_no_na

# Printing the energy value per serving
cat("Energy values:", energy_vals_no_na[1], "\n")

# Getting the index of the line containing words "Serving size"
serving_line_index <- grep("Serving size", lines)

# Extracting the serving size value from the line
serving_str <- lines[[serving_line_index]]
serving_size <- str_extract(serving_str, "\\d+\\.\\d+")
serving_size_numeric <- as.numeric(serving_size)

# Print the serving size
cat("Serving size:", serving_size_numeric, "g\n")