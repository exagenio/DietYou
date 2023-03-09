library(tesseract)
library(magick)
library(stringr)

fdo <- image_read("newtable.png")

fdo_processed <- image_resize(fdo, "1000x")
fdo_processed <- image_contrast(fdo_processed)
fdo_processed <- image_convert(fdo_processed, "gray")
fdo_processed

text <- ocr(fdo_processed)

# Split the lines into a character vector
lines <- str_split(text, "\n")[[1]]

# Find the index of the line containing "Serving size"
serving_size_index <- grep("Serving size", lines)

# Extract the serving size line
serving_size_line <- lines[serving_size_index]

# Extract the serving size value from the serving size line
serving_size_value <- gsub(".*Serving size: (\\d+\\.?\\d*)g.*", "\\1", serving_size_line)

# Print the serving size and its value
cat("Serving size:", serving_size_value, "\n")

# Find the line with either "Energy" or "Calories"
energy_line_index <- grep("Energy|Calories", lines)

# Extract the energy or calorie values from the line
energy_str <- lines[[energy_line_index]]
energy_vals <- ifelse(grepl("Energy", energy_str), 
                      str_extract(energy_str, "(?<=Energy\\s)[0-9]+"),
                      str_extract(energy_str, "(?<=Calories\\s)[0-9]+"))
energy_vals_numeric <- as.numeric(energy_vals)

energy_vals_no_na <- na.omit(energy_vals_numeric)

# Print the two energy values
cat("Energy values:", energy_vals_no_na[1], "\n")