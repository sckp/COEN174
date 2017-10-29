CREATE TABLE Advisors (
        advisor_id INTEGER,
        first_name VARCHAR(256),
        last_name VARCHAR(256),
        email VARCHAR(256),
        password VARCHAR(256)
);

CREATE TABLE Equivalencies (
        equivalency_id INTEGER,
        scu_course_name VARCHAR(256),
        scu_course_abbrv VARCHAR(256),
        nonscu_university_name VARCHAR(256),
        nonscu_course_name VARCHAR(256),
        nonscu_course_abbrv VARCHAR(256),
        approved BIT,
        notes VARCHAR(256)
);
