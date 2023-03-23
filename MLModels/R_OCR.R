library(tesseract)
library(magick)
library(stringr)
# Get the command line arguments
args <- commandArgs(trailingOnly = TRUE)
fdo <- image_read(args[1])

fdo_processed <- image_resize(fdo, "1000x")
fdo_processed <- image_contrast(fdo_processed)
fdo_processed <- image_convert(fdo_processed, "gray")
fdo_processed

text <- ocr(fdo_processed)

# Split the lines into a character vector
lines <- str_split(text, "\n")[[1]]
lines

# Find the index of the line containing "Serving size"
serving_size_index <- grep("Serving size", lines)

# Find the index of the line containing "Serving size"
serving_size_index <- grep("Serving size", lines)

# Extract the serving size line
serving_size_line <- lines[serving_size_index]

# Extract the serving size value and its unit from the serving size line
serving_size_value <- gsub(".*Serving size: (\\d+\\.?\\d*)\\s*(g|ml).*", "\\1 \\2", serving_size_line)

# Print the serving size value and its unit
cat("Serving size:", serving_size_value, "\n")

# Find the line with either "Energy" or "Calories"
energy_line_index <- grep("Energy|Calories", lines)

# Extract the energy or calorie values from the line
energy_str <- lines[[energy_line_index]]
energy_vals <- ifelse(grepl("Energy", energy_str), 
                      str_extract(energy_str, "(?<=Energy\\s)[0-9]+\\.*[0-9]*"), # include decimals
                      str_extract(energy_str, "(?<=Calories\\s)[0-9]+\\.*[0-9]*"))
energy_unit <- ifelse(grepl("kJ", energy_str), "kJ", 
                      ifelse(grepl("kcal", energy_str), "kcal", "unknown"))
energy_vals_numeric <- as.numeric(energy_vals)


energy_vals_no_na <- na.omit(energy_vals_numeric)


# Print the two energy values
cat("Energy values:", energy_vals_no_na[1], energy_unit, "\n")