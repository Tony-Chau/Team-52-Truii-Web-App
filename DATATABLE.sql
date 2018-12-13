CREATE TABLE GraphTable (GraphID INT NOT NULL AUTO_INCREMENT PRIMARY KEY, TableID INT NOT NULL, UserID INT NOT NULL, DateCreated DATETIME NOT NULL, GraphType VARCHAR(255) NOT NULL);
CREATE TABLE UserTable (UserID INT NOT NULL AUTO_INCREMENT PRIMARY KEY, Name VARCHAR(255) NOT NULL, Username VARCHAR(255) NOT NULL, Password VARCHAR(255) NOT NULL);
CREATE TABLE TableList (TableID INT NOT NULL AUTO_INCREMENT PRIMARY KEY, TableName VARCHAR(255) NOT NULL, CreatedBY DATETIME NOT NULL, DateCreated DATETIME NOT NULL, UserID INT NOT NULL);
CREATE TABLE CustomFieldTable (CustomFieldID INT NOT NULL AUTO_INCREMENT PRIMARY KEY, FieldID INT NOT NULL, GraphID INT NOT NULL, ColourCode VARCHAR(255) NOT NULL);
CREATE TABLE FieldTable(FieldID INT NOT NULL AUTO_INCREMENT PRIMARY KEY, FieldName VARCHAR(255) NOT NULL, TableID INT NOT NULL, DataType VARCHAR(255) NOT NULL);
CREATE TABLE GraphColumnTable(GraphColumnID INT NOT NULL AUTO_INCREMENT PRIMARY KEY, GraphID INT NOT NULL, FieldID INT NOT NULL, Axis VARCHAR(255) NOT NULL);
