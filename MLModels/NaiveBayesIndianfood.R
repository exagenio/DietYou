da <- read.csv("indian_food.csv")

str(da)

library(e1071)
library(caTools)
library(caret)

split <- sample.split(da, SplitRatio = 0.7)
train_cl <- subset(da, split == TRUE)
test_cl <- subset(da, split == FALSE)

# Subset numeric columns
numeric_cols <- sapply(train_cl, is.numeric)
train_numeric <- train_cl[, numeric_cols]
test_numeric <- test_cl[, numeric_cols]

train_scale <- scale(train_numeric)
test_scale <- scale(test_numeric)

set.seed(100)  # Setting Seed
classifier_cl <- naiveBayes(region ~ ., da = train_cl)
classifier_cl

y_pred <- predict(classifier_cl, newdata = test_cl)

cm <- table(test_cl$region, y_pred)
cm

confusionMatrix(cm)

accuracy <- sum(diag(cm))/sum(cm)
accuracy

new_observation <- data.frame(name = "Balu shahi",
                              ingredients = "Maida flour, yogurt, oil, sugar",
                              diet = "vegetarian",
                              prep_time = 45,
                              cook_time = 25,
                              flavor_profile = "sweet",
                              course = "dessert",
                              state = "West Bengal")
predicted_species <- predict(classifier_cl, newdata = new_observation)
predicted_species