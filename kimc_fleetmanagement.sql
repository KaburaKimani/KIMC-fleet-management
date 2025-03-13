CREATE TABLE drivers (
    driverid INT AUTO_INCREMENT PRIMARY KEY,
    fullName VARCHAR(50) NOT NULL,    
    email VARCHAR(100) NOT NULL UNIQUE, 
    password VARCHAR(255) NOT NULL,
    dateofbirth DATE NOT NULL,
    phoneno VARCHAR(15) NOT NULL,
    profile_photo VARCHAR(255) DEFAULT '',
    licenseno VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE vehicles (
    vehicleid INT AUTO_INCREMENT PRIMARY KEY,
    driverid INT NOT NULL,       
    make VARCHAR(50) NOT NULL,        
    model VARCHAR(50) NOT NULL,        
    year INT NOT NULL,             
    licenseplate VARCHAR(20) UNIQUE, 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    FOREIGN KEY (driverid) REFERENCES drivers(driverid) ON DELETE CASCADE 
);