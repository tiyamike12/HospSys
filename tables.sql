CREATE TABLE Patient (
                         patient_id INT PRIMARY KEY,
                         first_name VARCHAR(50),
                         last_name VARCHAR(50),
                         date_of_birth DATE,
                         gender CHAR(1),
                         address VARCHAR(100),
                         phone_number VARCHAR(20),
                         email_address VARCHAR(100),
                         medical_history TEXT,
                         insurance_information VARCHAR(100)
);

CREATE TABLE Doctor (
                        doctor_id INT PRIMARY KEY,
                        first_name VARCHAR(50),
                        last_name VARCHAR(50),
                        specialty VARCHAR(100),
                        phone_number VARCHAR(20),
                        email_address VARCHAR(100)
);

CREATE TABLE Staff (
                       staff_id INT PRIMARY KEY,
                       first_name VARCHAR(50),
                       last_name VARCHAR(50),
                       role VARCHAR(100),
                       phone_number VARCHAR(20),
                       email_address VARCHAR(100)
);

CREATE TABLE Appointment (
                             appointment_id INT PRIMARY KEY,
                             patient_id INT REFERENCES Patient(patient_id),
                             doctor_id INT REFERENCES Doctor(doctor_id),
                             appointment_date_time DATETIME,
                             status VARCHAR(20)
);

CREATE TABLE EHR (
                     ehr_id INT PRIMARY KEY,
                     patient_id INT REFERENCES Patient(patient_id),
                     doctor_id INT REFERENCES Doctor(doctor_id),
                     visit_date_time DATETIME,
                     medical_history TEXT,
                     test_results TEXT,
                     diagnoses TEXT,
                     treatment_plan TEXT
);

CREATE TABLE Billing (
                         payment_id INT PRIMARY KEY,
                         patient_id INT REFERENCES Patient(patient_id),
                         service_date DATE,
                         service_type VARCHAR(100),
                         cost DECIMAL(10,2),
                         insurance_information VARCHAR(100),
                         payment_status VARCHAR(20)
);

CREATE TABLE Inventory (
                           item_id INT PRIMARY KEY,
                           item_name VARCHAR(100),
                           item_description VARCHAR(200),
                           quantity INT,
                           supplier VARCHAR(100),
                           cost DECIMAL(10,2)
);

CREATE TABLE Pharmacy (
                          medication_id INT PRIMARY KEY,
                          medication_name VARCHAR(100),
                          dosage VARCHAR(50),
                          quantity INT,
                          manufacturer VARCHAR(100),
                          expiration_date DATE
);

CREATE TABLE Laboratory (
                            test_id INT PRIMARY KEY,
                            test_name VARCHAR(100),
                            test_description VARCHAR(200),
                            test_results TEXT,
                            doctor_id INT REFERENCES Doctor(doctor_id),
                            patient_id INT REFERENCES Patient(patient_id),
                            test_date_time DATETIME
);

CREATE TABLE Patient_Portal (
                                user_id INT PRIMARY KEY,
                                username VARCHAR(50),
                                password VARCHAR(50),
                                patient_id INT REFERENCES Patient(patient_id),
                                email_address VARCHAR(100),
                                medical_records_access BOOLEAN,
                                appointment_scheduling BOOLEAN,
                                medication_refill_request BOOLEAN
);
