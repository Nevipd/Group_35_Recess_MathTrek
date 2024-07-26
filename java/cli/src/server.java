// Javac server.java client.java
// java -cp .;.\mysql-connector-j-8.0.31.jar server.java 5001

import java.net.*;
import java.io.*;
import java.sql.*;
import java.util.*;

// import java.util.Properties;
// import javax.mail.*;
// import javax.mail.internet.*;

public class server {
    public static final String DB_URL = "jdbc:mysql://localhost:3306/lara_math_web";
    public static final String DB_USER = "root";
    public static final String DB_PASSWORD = "";
    public static Connection connection = null;

    // START OF DATABASE METHODS //
    // ...........................//
    public static class DbHelper {
        Connection connection;

        public DbHelper(Connection connection) {
            this.connection = connection;
        }

        public void createTable() {
            String query = "CREATE TABLE IF NOT EXISTS student(id INT PRIMARY KEY UNIQUE AUTO_INCREMENT, username VARCHAR(20), firstName VARCHAR(20), lastName VARCHAR(20), emailAddress VARCHAR(40), date_of_birth DATE, school_registration_number VARCHAR(55), image_file BLOB, password VARCHAR(255))";
            String query1 = "CREATE TABLE IF NOT EXISTS schools(id INT PRIMARY KEY UNIQUE AUTO_INCREMENT, school_name VARCHAR(55), district VARCHAR(20), school_registration_number VARCHAR(55), representative_name VARCHAR(20), representative_email VARCHAR(40))";
            String query2 = "CREATE TABLE IF NOT EXISTS applicants(id INT PRIMARY KEY UNIQUE AUTO_INCREMENT, username VARCHAR(20), firstName VARCHAR(20), lastName VARCHAR(20), emailAddress VARCHAR(40), date_of_birth DATE, school_registration_number VARCHAR(55), status VARCHAR(20))";
            String query3 = "CREATE TABLE IF NOT EXISTS participants(id INT PRIMARY KEY UNIQUE AUTO_INCREMENT, username VARCHAR(20), school_registration_number VARCHAR(55), status VARCHAR(10))";
            String query4 = "CREATE TABLE IF NOT EXISTS rejected(id INT PRIMARY KEY UNIQUE AUTO_INCREMENT, username VARCHAR(20), school_registration_number VARCHAR(55), status VARCHAR(10))";
            String query5 = "CREATE TABLE IF NOT EXISTS attempted_challenges (id INT PRIMARY KEY AUTO_INCREMENT, username VARCHAR(255) NOT NULL, school_reg_no VARCHAR(255) NOT NULL, challenge_name VARCHAR(255) NOT NULL, total_questions INT NOT NULL, correct_answers INT NOT NULL, wrong_answers INT NOT NULL, skipped_questions INT NOT NULL, challenge_marks INT NOT NULL, total_score INT NOT NULL, timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";
            String query6 = "CREATE TABLE IF NOT EXISTS representatives (" +
                    "id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, " +
                    "school_id BIGINT UNSIGNED NOT NULL, " +
                    "representative_email VARCHAR(255) NOT NULL, " +
                    "representative_name VARCHAR(255) NOT NULL, " +
                    "password VARCHAR(255) NOT NULL, " +
                    "created_at TIMESTAMP NULL DEFAULT NULL, " +
                    "updated_at TIMESTAMP NULL DEFAULT NULL " +
                    ")";

            try {
                Statement statement = connection.createStatement();
                statement.execute(query);
                statement.execute(query1);
                statement.execute(query2);
                statement.execute(query3);
                statement.execute(query4);
                statement.execute(query5);
                statement.execute(query6);
            } catch (SQLException e) {
                e.printStackTrace();
            }
        }

        public boolean isValidSchoolRegistrationNumber(String school_registration_number) {
            String query = "SELECT COUNT(*) FROM schools WHERE school_registration_number = ?";
            try {
                PreparedStatement preparedStatement = connection.prepareStatement(query);
                preparedStatement.setString(1, school_registration_number);
                ResultSet resultSet = preparedStatement.executeQuery();
                if (resultSet.next()) {
                    return resultSet.getInt(1) > 0;
                }
            } catch (SQLException e) {
                e.printStackTrace();
            }
            return false;
        }

        public String registerStudent(String username, String firstName, String lastName, String emailAddress,
                String date_of_birth, String school_registration_number, String image_file_path, String password) {

            if (!isValidSchoolRegistrationNumber(school_registration_number)) {
                return "Error: Invalid school registration number. Registration denied.";
            }
            String query = "INSERT INTO student (username, firstName, lastName, emailAddress, date_of_birth, school_registration_number, image_file, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            try {
                PreparedStatement preparedStatement = connection.prepareStatement(query);
                preparedStatement.setString(1, username);
                preparedStatement.setString(2, firstName);
                preparedStatement.setString(3, lastName);
                preparedStatement.setString(4, emailAddress);
                preparedStatement.setString(5, date_of_birth);
                preparedStatement.setString(6, school_registration_number);
                preparedStatement.setString(8, password);

                // Read image file and set it as a BLOB
                File imageFile = new File(image_file_path);
                if (!imageFile.exists()) {
                    return "Error: Image file not found.";
                }
                FileInputStream fis = new FileInputStream(imageFile);
                preparedStatement.setBinaryStream(7, fis, (int) imageFile.length());

                preparedStatement.executeUpdate();

                // // Fetching the representative email to send the email notification
                // String repEmail = getRepresentativeEmail(school_registration_number);
                // if (repEmail != null) {
                // sendEmail(repEmail, username, firstName, lastName, emailAddress,
                // date_of_birth,
                // school_registration_number);
                // }

                System.out.println("Registration successful!");
                return "Registration successful!";
            } catch (SQLException | FileNotFoundException e) {
                e.printStackTrace();
                System.out.println("Error registering user: " + e.getMessage());
                return null;
            }
        }

        public String loginStudent(String username, String password) {
            String query = "SELECT * FROM student WHERE username = ? AND password = ?";
            try {
                PreparedStatement preparedStatement = connection.prepareStatement(query);
                preparedStatement.setString(1, username);
                preparedStatement.setString(2, password);
                ResultSet rs = preparedStatement.executeQuery();
                if (rs.next()) {
                    return "Login Successful!";
                }
            } catch (SQLException e) {
                System.out.println(e.getMessage());
            }
            return null;
        }

        public String loginSchoolRepresentative(String representativeName, String schoolRegistrationNumber) {
            String query = "SELECT * FROM schools WHERE representative_name = ? AND school_registration_number = ?";
            try {
                PreparedStatement preparedStatement = connection.prepareStatement(query);
                preparedStatement.setString(1, representativeName);
                preparedStatement.setString(2, schoolRegistrationNumber);
                ResultSet rs = preparedStatement.executeQuery();
                if (rs.next()) {
                    return "Login Successful!";
                }
            } catch (SQLException e) {
                System.out.println(e.getMessage());
            }
            return null;
        }

        public String insertStudentDetails(String username, String firstName, String lastName,
                String emailAddress, String dateOfBirth, String schoolRegistrationNumber) {

            String query = "INSERT INTO applicants (username, firstName, lastName, emailAddress, date_of_birth, school_registration_number, status) "
                    +
                    "VALUES (?, ?, ?, ?, ?, ?, ?)";

            try {
                PreparedStatement preparedStatement = connection.prepareStatement(query);
                preparedStatement.setString(1, username);
                preparedStatement.setString(2, firstName);
                preparedStatement.setString(3, lastName);
                preparedStatement.setString(4, emailAddress);
                preparedStatement.setString(5, dateOfBirth);
                preparedStatement.setString(6, schoolRegistrationNumber);
                preparedStatement.setString(7, "Pending");

                preparedStatement.executeUpdate();

                System.out.println("Student details added to applicants table with status: pending");
                return "Registration successful!";
            } catch (SQLException e) {
                e.printStackTrace();
                System.out.println("Error inserting student details: " + e.getMessage());
                return null;
            }
        }

        public boolean confirmApplicant(String username, String representativeName) {
            String insertParticipantSQL = "INSERT INTO participants (username, school_registration_number, status) SELECT username, school_registration_number, 'confirmed' FROM applicants WHERE username = ?";
            try {
                PreparedStatement preparedStatement = connection.prepareStatement(insertParticipantSQL);
                preparedStatement.setString(1, username);
                int rowsInserted = preparedStatement.executeUpdate();

                // Delete from applicants table
                String deleteApplicantSQL = "DELETE FROM applicants WHERE username = ?";
                PreparedStatement deleteStmt = connection.prepareStatement(deleteApplicantSQL);
                deleteStmt.setString(1, username);
                int rowsDeleted = deleteStmt.executeUpdate();

                return rowsInserted > 0 && rowsDeleted > 0;

            } catch (SQLException e) {
                e.printStackTrace();
                return false;
            }
        }

        public boolean rejectApplicant(String username, String representativeName) {
            String insertRejectedSQL = "INSERT INTO rejected (username, school_registration_number, status) SELECT username, school_registration_number, 'rejected' FROM applicants WHERE username = ?";
            try {

                // Insert into rejected table
                PreparedStatement insertStmt = connection.prepareStatement(insertRejectedSQL);
                insertStmt.setString(1, username);
                int rowsInserted = insertStmt.executeUpdate();

                // Delete from applicants table
                String deleteApplicantSQL = "DELETE FROM applicants WHERE username = ?";
                PreparedStatement deleteStmt = connection.prepareStatement(deleteApplicantSQL);
                deleteStmt.setString(1, username);
                int rowsDeleted = deleteStmt.executeUpdate();

                return rowsInserted > 0 && rowsDeleted > 0;
            } catch (SQLException e) {
                e.printStackTrace();
                return false;
            }
        }

        // private String getRepresentativeEmail(String school_registration_number) {
        // String query = "SELECT representative_email FROM schools WHERE
        // school_registration_number = ?";
        // try {
        // PreparedStatement preparedStatement = connection.prepareStatement(query);
        // preparedStatement.setString(1, school_registration_number);
        // ResultSet resultSet = preparedStatement.executeQuery();
        // if (resultSet.next()) {
        // return resultSet.getString("representative_email");
        // }
        // } catch (SQLException e) {
        // e.printStackTrace();
        // }
        // return null;
        // }

        // private void sendEmail(String to, String username, String firstName, String
        // lastName, String emailAddress,
        // String date_of_birth, String school_registration_number) {
        // final String from = "your-email@example.com";
        // final String password = "your-email-password";

        // Properties props = new Properties();
        // props.put("mail.smtp.host", "smtp.example.com");
        // props.put("mail.smtp.port", "587");
        // props.put("mail.smtp.auth", "true");
        // props.put("mail.smtp.starttls.enable", "true");

        // Session session = Session.getInstance(props, new javax.mail.Authenticator() {
        // protected PasswordAuthentication getPasswordAuthentication() {
        // return new PasswordAuthentication(from, password);
        // }
        // });

        // try {
        // Message message = new MimeMessage(session);
        // message.setFrom(new InternetAddress(from));
        // message.setRecipients(Message.RecipientType.TO, InternetAddress.parse(to));
        // message.setSubject("New Student Registration");
        // message.setText("Details of the new student:\n\n" +
        // "Username: " + username + "\n" +
        // "First Name: " + firstName + "\n" +
        // "Last Name: " + lastName + "\n" +
        // "Email: " + emailAddress + "\n" +
        // "Date of Birth: " + date_of_birth + "\n" +
        // "School Registration Number: " + school_registration_number);

        // Transport.send(message);

        // System.out.println("Email sent successfully!");

        // } catch (MessagingException e) {
        // throw new RuntimeException(e);
        // }
        // }

        public boolean isRepresentative(String username) {
            String query = "SELECT COUNT(*) AS count FROM schools WHERE representative_name = ?";
            try {
                PreparedStatement preparedStatement = connection.prepareStatement(query);
                preparedStatement.setString(1, username);
                ResultSet resultSet = preparedStatement.executeQuery();
                if (resultSet.next()) {
                    int count = resultSet.getInt("count");
                    return count > 0;
                }
            } catch (SQLException e) {
                e.printStackTrace();
                System.out.println("Error checking representative status: " + e.getMessage());
            }
            return false;
        }

        public boolean isStudent(String username) {
            String query = "SELECT COUNT(*) AS count FROM student WHERE username = ?";
            try {
                PreparedStatement preparedStatement = connection.prepareStatement(query);
                preparedStatement.setString(1, username);
                ResultSet resultSet = preparedStatement.executeQuery();
                if (resultSet.next()) {
                    int count = resultSet.getInt("count");
                    return count > 0;
                }
            } catch (SQLException e) {
                e.printStackTrace();
                System.out.println("Error checking student status: " + e.getMessage());
            }
            return false;
        }

        public String getSchoolRegistrationNumber(String representativeName) {
            String query = "SELECT school_registration_number FROM schools WHERE representative_name = ?";
            try {
                PreparedStatement preparedStatement = connection.prepareStatement(query);
                preparedStatement.setString(1, representativeName);
                ResultSet resultSet = preparedStatement.executeQuery();
                if (resultSet.next()) {
                    return resultSet.getString("school_registration_number");
                }
            } catch (SQLException e) {
                e.printStackTrace();
                System.out.println("Error retrieving school registration number: " + e.getMessage());
            }
            return null;
        }

        public List<String[]> getPendingApplicants(String schoolRegistrationNumber) {
            List<String[]> pendingApplicants = new ArrayList<>();
            String query = "SELECT username, firstName, lastName, emailAddress, date_of_birth, school_registration_number, status FROM applicants WHERE status = 'pending' AND school_registration_number = ?";
            try {
                PreparedStatement preparedStatement = connection.prepareStatement(query);
                preparedStatement.setString(1, schoolRegistrationNumber);
                ResultSet resultSet = preparedStatement.executeQuery();
                while (resultSet.next()) {
                    String username = resultSet.getString("username");
                    String firstName = resultSet.getString("firstName");
                    String lastName = resultSet.getString("lastName");
                    String emailAddress = resultSet.getString("emailAddress");
                    String dateOfBirth = resultSet.getString("date_of_birth");
                    String school_registration_number = resultSet.getString("school_registration_number");
                    String status = resultSet.getString("status");
                    pendingApplicants.add(new String[] { username, firstName, lastName, emailAddress, dateOfBirth,
                            school_registration_number, status });
                }
                return pendingApplicants;
            } catch (SQLException e) {
                e.printStackTrace();
                System.out.println("Error retrieving pending applicants: " + e.getMessage());
            }
            return null;
        }

        public String getStudentStatus(String username) {
            String statusQuery = "SELECT 'participants' AS source, status FROM participants WHERE username = ? " +
                    "UNION " +
                    "SELECT 'applicants' AS source, status FROM applicants WHERE username = ? " +
                    "UNION " +
                    "SELECT 'rejected' AS source, status FROM rejected WHERE username = ?";
            try {
                PreparedStatement preparedStatement = connection.prepareStatement(statusQuery);
                preparedStatement.setString(1, username);
                preparedStatement.setString(2, username);
                preparedStatement.setString(3, username);
                ResultSet resultSet = preparedStatement.executeQuery();
                if (resultSet.next()) {
                    String source = resultSet.getString("source");
                    @SuppressWarnings("unused")
                    String status = resultSet.getString("status");

                    if (source.equals("participants")) {
                        return "confirmed";
                    } else if (source.equals("applicants")) {
                        return "pending";
                    } else if (source.equals("rejected")) {
                        return "rejected";
                    }
                } else {
                    return "not found";
                }
            } catch (SQLException e) {
                e.printStackTrace();
                System.out.println("Error retrieving student status: " + e.getMessage());
                return "error";
            }
            return "not found";
        }

        public List<String[]> getChallenges() {
            List<String[]> challenges = new ArrayList<>();
            String query = "SELECT name, description, start_date, end_date, num_questions FROM challenges";
            try {
                PreparedStatement preparedStatement = connection.prepareStatement(query);
                ResultSet resultSet = preparedStatement.executeQuery();
                while (resultSet.next()) {
                    String name = resultSet.getString("name");
                    String description = resultSet.getString("description");
                    String startDate = resultSet.getString("start_date");
                    String endDate = resultSet.getString("end_date");
                    String numQuestions = resultSet.getString("num_questions");
                    challenges.add(new String[] { name, description, startDate, endDate, numQuestions });
                }
                return challenges;
            } catch (SQLException e) {
                e.printStackTrace();
                System.out.println("Error retrieving challenges: " + e.getMessage());
            }
            return null;
        }

        // Method to fetch challenges that are not expired
        public List<String[]> getActiveChallenges() {
            List<String[]> challenges = new ArrayList<>();
            String query = "SELECT name, description, start_date, end_date, num_questions FROM challenges WHERE end_date >= CURDATE()";
            try {
                PreparedStatement preparedStatement = connection.prepareStatement(query);
                ResultSet resultSet = preparedStatement.executeQuery();
                while (resultSet.next()) {
                    String name = resultSet.getString("name");
                    String description = resultSet.getString("description");
                    String startDate = resultSet.getString("start_date");
                    String endDate = resultSet.getString("end_date");
                    String numQuestions = resultSet.getString("num_questions");
                    challenges.add(new String[] { name, description, startDate, endDate, numQuestions });
                }
            } catch (SQLException e) {
                e.printStackTrace();
                System.out.println("Error retrieving challenges: " + e.getMessage());
            }
            return challenges;
        }

        // Method to fetch questions for a specific challenge
        public List<String[]> getQuestionsForChallenge(String challengeName) {
            List<String[]> questions = new ArrayList<>();
            String query = "SELECT question_text, choice1, choice2, choice3, choice4, correct_choice " +
                    "FROM questions WHERE LOWER(file_name) = LOWER(?)";
            try {
                PreparedStatement preparedStatement = connection.prepareStatement(query);
                preparedStatement.setString(1, challengeName);
                ResultSet resultSet = preparedStatement.executeQuery();
                while (resultSet.next()) {
                    String question = resultSet.getString("question_text");
                    String choice1 = resultSet.getString("choice1");
                    String choice2 = resultSet.getString("choice2");
                    String choice3 = resultSet.getString("choice3");
                    String choice4 = resultSet.getString("choice4");
                    String correctAnswer = resultSet.getString("correct_choice");
                    questions.add(new String[] { question, choice1, choice2, choice3, choice4, correctAnswer });
                    // System.out.println("Fetched question: " + question); // Debugging line of
                    // code
                }
            } catch (SQLException e) {
                e.printStackTrace();
                System.out.println("Error retrieving questions: " + e.getMessage());
            }
            return questions;
        }

        // Method to save challenge details in the database
        public void saveAttemptedChallenges(String username, String schoolRegNo, String challengeName,
                int totalQuestions, int correctAnswers,
                int wrongAnswers, int skippedQuestions,
                int challengeMarks, int challengeScore) {
            String query = "INSERT INTO attempted_challenges (username, school_reg_no, challenge_name, total_questions, correct_answers, wrong_answers, skipped_questions, "
                    +
                    "challenge_marks, total_score) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

            try {
                PreparedStatement preparedStatement = connection.prepareStatement(query);
                preparedStatement.setString(1, username);
                preparedStatement.setString(2, schoolRegNo);
                preparedStatement.setString(3, challengeName);
                preparedStatement.setInt(4, totalQuestions);
                preparedStatement.setInt(5, correctAnswers);
                preparedStatement.setInt(6, wrongAnswers);
                preparedStatement.setInt(7, skippedQuestions);
                preparedStatement.setInt(8, challengeMarks);
                preparedStatement.setInt(9, challengeScore);

                int rowsInserted = preparedStatement.executeUpdate();
                if (rowsInserted > 0) {
                    System.out.println("Challenge details saved successfully!");
                }
            } catch (SQLException e) {
                e.printStackTrace();
            }
        }

        // Method to get registration number by username
        public String getRegNoByUsername(String username) {
            String query = "SELECT school_registration_number FROM student WHERE username = ?";
            try {
                PreparedStatement preparedStatement = connection.prepareStatement(query);
                preparedStatement.setString(1, username);
                ResultSet rs = preparedStatement.executeQuery();

                if (rs.next()) {
                    return rs.getString("school_registration_number");
                }
            } catch (SQLException e) {
                e.printStackTrace();
            }
            return null;
        }

    }

    // END OF DATABASE METHODS
    // ...........................//

    @SuppressWarnings("unused")
    public static void main(String[] args) {
        if (args.length != 1) {
            System.err.println("Usage: java EchoServer <port number>");
            System.exit(1);
        }
        int portNumber = Integer.parseInt(args[0]);
        String currentUsername = null;

        server.DbHelper myDbHelper = null;
        try {
            Class.forName("com.mysql.cj.jdbc.Driver");
            connection = DriverManager.getConnection(DB_URL, DB_USER, DB_PASSWORD);
            if (connection != null) {
                System.out.println("Connected to the database");
                myDbHelper = new DbHelper(connection);
                myDbHelper.createTable();
            } else {
                System.out.println("Not connected to the database");
            }
        } catch (ClassNotFoundException | SQLException e) {
            e.printStackTrace();
        }

        System.out.println("Waiting for clients.......");

        try (ServerSocket serverSocket = new ServerSocket(portNumber);
                Socket clientSocket = serverSocket.accept();
                PrintWriter out = new PrintWriter(clientSocket.getOutputStream(), true);
                BufferedReader in = new BufferedReader(new InputStreamReader(clientSocket.getInputStream()));) {

            String inputLine;
            while ((inputLine = in.readLine()) != null) {
                if (inputLine.equalsIgnoreCase("register")) {
                    String username = in.readLine();
                    String firstName = in.readLine();
                    String lastName = in.readLine();
                    String emailAddress = in.readLine();
                    String date_of_birth = in.readLine();
                    String school_registration_number = in.readLine();
                    String image_file = in.readLine();
                    String password = in.readLine();

                    String response = myDbHelper.registerStudent(username, firstName, lastName, emailAddress,
                            date_of_birth, school_registration_number, image_file, password);
                    out.println(response);
                    if (response != null) {
                        out.println("Registration successful");

                        String insertResult = myDbHelper.insertStudentDetails(username, firstName, lastName,
                                emailAddress, date_of_birth, school_registration_number);

                        if (insertResult != null && insertResult.equals("Registration successful!")) {
                            System.out.println("Student details added to applicants table with status: pending");
                        } else {
                            System.out.println("Failed to add student details to applicants table");
                        }
                    } else {
                        out.println("Echo: " + inputLine);

                    }
                } else if (inputLine.equalsIgnoreCase("login")) {
                    String userType = in.readLine();

                    if (userType.equalsIgnoreCase("student")) {
                        String username = in.readLine();
                        String password = in.readLine();

                        String loginResult = myDbHelper.loginStudent(username, password);
                        if (loginResult != null) {
                            out.println("Login Successful!");
                            System.out.println("Student login successful");
                            currentUsername = username;

                        } else {
                            out.println("Invalid username or password. Login Failed");
                            System.out.println("Invalid username or school registration number. Login Failed");
                        }
                    } else if (userType.equalsIgnoreCase("representative")) {
                        String representativeName = in.readLine();
                        String schoolRegistrationNumber = in.readLine();

                        String loginResult = myDbHelper.loginSchoolRepresentative(representativeName,
                                schoolRegistrationNumber);
                        if (loginResult != null) {
                            out.println("Login Successful!");
                            System.out.println("School representative login successful");
                            currentUsername = representativeName;
                            System.out.println("         ");
                            System.out.println(currentUsername);

                        } else {
                            out.println("Invalid representative name or school registration number. Login Failed");
                            System.out
                                    .println(
                                            "Invalid representative name or school registration number. Login Failed");
                        }
                    } else {
                        out.println("Invalid user type selected. Please try again.");
                    }

                } else if (inputLine.equalsIgnoreCase("viewApplicants")) {
                    System.out.println(inputLine);
                    if (myDbHelper.isRepresentative(currentUsername)) {
                        System.out.println("Current username: " + currentUsername);

                        // We retrieve applicants whose status is 'pending' and school registration
                        // number matches
                        String schoolRegistrationNumber = myDbHelper.getSchoolRegistrationNumber(currentUsername);
                        List<String[]> pendingApplicants = myDbHelper
                                .getPendingApplicants(schoolRegistrationNumber);

                        // We then send the list of pending applicants to the client
                        if (pendingApplicants != null && !pendingApplicants.isEmpty()) {
                            StringBuilder responseBuilder = new StringBuilder("Pending Applicants:");
                            for (String[] applicant : pendingApplicants) {
                                responseBuilder.append(String.join("|", applicant)).append(",");
                            }
                            out.println(responseBuilder.toString());
                            System.out.println("Pending applicants sent to client: " + responseBuilder.toString());

                        } else {
                            out.println("No pending applicants found for your school.");
                        }
                    } else {
                        out.println("Unauthorized access. Please login as a school representative.");
                    }
                } else if (inputLine.equalsIgnoreCase("confirm")) {
                    if (myDbHelper.isRepresentative(currentUsername)) {
                        String confirmType = in.readLine();

                        if (confirmType.equals("yes")) {
                            String username = in.readLine();
                            boolean confirmResult = myDbHelper.confirmApplicant(username, currentUsername);
                            if (confirmResult) {
                                out.println("Confirmation successful for " + username);
                            } else {
                                out.println("Error confirming " + username);
                            }
                        } else if (confirmType.equalsIgnoreCase("no")) {
                            String username = in.readLine();
                            boolean rejectResult = myDbHelper.rejectApplicant(username, currentUsername);
                            if (rejectResult) {
                                out.println("You have rejected " + username + "in your school");
                            } else {
                                out.println("Error rejecting " + username);
                            }
                        } else {
                            out.println("Invalid confirmation type. Use 'yes' or 'no'.");
                        }
                    } else {
                        out.println("Unauthorized access. Please login as a school representative.");
                    }
                } else if (inputLine.equalsIgnoreCase("viewChallenges")) {
                    if (myDbHelper.isStudent(currentUsername)) {
                        System.out.println("Current student: " + currentUsername);

                        // Get the status of the student
                        String studentStatus = myDbHelper.getStudentStatus(currentUsername);
                        System.out.println("The student status: " + studentStatus);
                        if (studentStatus.equals("pending")) {
                            System.out.println("Current student: " + currentUsername + " is pending\n");
                            out.println(
                                    "You are currently pending. Please wait for the school to confirm your application.");
                        } else if (studentStatus.equals("confirmed")) {
                            System.out.println("Current student: " + currentUsername + " is confirmed\n");

                            // Fetch challenges
                            List<String[]> challenges = myDbHelper.getChallenges();
                            if (challenges != null && !challenges.isEmpty()) {
                                StringBuilder challengesResponse = new StringBuilder("confirmed:");
                                for (String[] challenge : challenges) {
                                    String challengeDetails = String.join("|", challenge);
                                    challengesResponse.append(challengeDetails).append(";;");
                                }
                                // Remove the last separator
                                if (challengesResponse.length() > 0) {
                                    challengesResponse.setLength(challengesResponse.length() - 2);
                                }
                                out.println(challengesResponse.toString());
                                System.out.println("Challenges sent to client: " + challengesResponse.toString());
                            } else {
                                out.println("No challenges available.");
                            }

                        } else {
                            System.out.println("Current student: " + currentUsername + " is rejected\n");
                            out.println("You are currently rejected. You cannot view the challenges.");
                        }
                    } else {
                        out.println("Unauthorized access. Please login as a student.");
                    }
                } else if (inputLine.equalsIgnoreCase("attemptChallenges")) {
                    if (myDbHelper.isStudent(currentUsername)) {
                        System.out.println("Current student: " + currentUsername);
                        String schoolRegNo = myDbHelper.getRegNoByUsername(currentUsername);

                        String challengeName = in.readLine(); // challenge name
                        System.out.println("Challenge name: " + challengeName);

                        // Fetch questions for the specific challenge
                        List<String[]> questions = myDbHelper.getQuestionsForChallenge(challengeName);
                        if (questions == null || questions.isEmpty()) {
                            out.println("No questions available for this challenge.");
                            continue;
                        }

                        Collections.shuffle(questions); // Randomize questions
                        int totalQuestions = Math.min(10, questions.size());
                        int correctAnswers = 0;
                        int challengeMarks = 0;
                        int wrongAnswers = 0;
                        int skippedQuestions = 0;
                        int totalMarks = totalQuestions * 5;
                        int maxAttempts = 3;
                        long challengeStartTime = System.currentTimeMillis();
                        int totalTimeLimit = 30 * 60 * 1000; // 30 minutes in milliseconds
                        int perQuestionTimeLimit = totalTimeLimit / totalQuestions; // Time per question
                        int challengeScore;
                        boolean challengeInProgress = true;

                        for (int attempt = 0; attempt < maxAttempts; attempt++) {
                            System.out.println("Attempt " + (attempt + 1) + " of " + maxAttempts + "remaining");
                            long attemptStartTime = System.currentTimeMillis();

                            out.println(totalQuestions); // Send the total number of questions to the client

                            int questionIndex = 0;
                            while (questionIndex < totalQuestions && challengeInProgress) {
                                if (System.currentTimeMillis() - challengeStartTime > totalTimeLimit) {
                                    out.println("Time is up for the entire challenge!");
                                    challengeInProgress = false;
                                    break;
                                }

                                String[] questionData = questions.get(questionIndex);
                                String question = questionData[0];
                                String[] choices = { questionData[1], questionData[2], questionData[3],
                                        questionData[4] };
                                String correctAnswer = questionData[5];

                                // Create a map from choice letter to answer
                                Map<String, String> choiceToAnswerMap = new HashMap<>();
                                choiceToAnswerMap.put("a", choices[0]);
                                choiceToAnswerMap.put("b", choices[1]);
                                choiceToAnswerMap.put("c", choices[2]);
                                choiceToAnswerMap.put("d", choices[3]);

                                // Send question to client
                                StringBuilder questionMessage = new StringBuilder("Question ");
                                questionMessage.append(questionIndex + 1).append(" of ").append(totalQuestions)
                                        .append(" | Time remaining: ")
                                        .append((perQuestionTimeLimit / 1000)
                                                - (System.currentTimeMillis() - challengeStartTime) / 1000)
                                        .append(" seconds | ").append(question).append("\nChoices: a) ")
                                        .append(choices[0])
                                        .append(" b) ").append(choices[1])
                                        .append(" c) ").append(choices[2]).append(" d) ").append(choices[3])
                                        .append("\n");

                                String messageToSend = questionMessage.toString();
                                out.println(messageToSend);
                                out.flush();

                                // Debugging line
                                System.out.println("Sent to client: " + messageToSend);

                                // Wait for client response
                                String answer = in.readLine();
                                if (answer == null) {
                                    continue;
                                }

                                if (answer.equalsIgnoreCase("skip")) {
                                    skippedQuestions++;
                                    challengeMarks = challengeMarks + 0;
                                    System.out.println("Skipped.");
                                } else if (choiceToAnswerMap.get(answer) != null &&
                                        choiceToAnswerMap.get(answer).equalsIgnoreCase(correctAnswer)) {
                                    correctAnswers++;
                                    challengeMarks = challengeMarks + 3;
                                    System.out.println("Correct!");
                                } else {
                                    wrongAnswers++;
                                    challengeMarks = challengeMarks - 3;
                                    System.out.println("Incorrect!");
                                }

                                // Check if time for the question has expired
                                if (System.currentTimeMillis() - attemptStartTime > perQuestionTimeLimit) {
                                    System.out.println("Time is up for this question!");
                                    break;
                                }

                                questionIndex++; // Move to the next question

                            }
                            out.println("Challenge completed!");
                            challengeScore = (int) (((double) challengeMarks / totalMarks) * 100);

                            System.out.println("Preparing to send challenge report to client...");

                            // Report results for this attempt
                            System.out.println("Sending final report to client...");
                            out.println("Attempt completed!");
                            out.flush();

                            String reportMessage = "Attempt completed!\n" +
                                    "Total Questions: " + totalQuestions + "\n" +
                                    "Correct Answers: " + correctAnswers + "\n" +
                                    "Wrong Answers: " + wrongAnswers + "\n" +
                                    "Skipped Questions: " + skippedQuestions + "\n" +
                                    "Total score: " + challengeScore;

                            out.println(reportMessage);
                            out.flush(); // Ensure the report is sent immediately

                            System.out.println("Final report sent to client:\n" + reportMessage);

                            challengeInProgress = false;
                            myDbHelper.saveAttemptedChallenges(currentUsername, schoolRegNo, challengeName,
                                    totalQuestions, correctAnswers, wrongAnswers, skippedQuestions, challengeMarks,
                                    challengeScore);
                            break;
                        }

                    } else {
                        out.println("Login as a student to access this command!");

                    }

                } else {
                    out.println("Echo: " + inputLine);
                }

            }

        } catch (

        IOException e) {
            System.out.println(
                    "Exception caught when trying to listen on port " + portNumber
                            + " or listening for a connection");
            System.out.println(e.getMessage());
        }

    }
}