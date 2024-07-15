// Javac server.java client.java
// java -cp .;.\mysql-connector-j-8.0.31.jar server.java 5001

import java.net.*;
import java.io.*;
import java.sql.*;
import java.util.List;
import java.util.ArrayList;

// import java.util.Properties;
// import javax.mail.*;
// import javax.mail.internet.*;

public class server {
    public static final String DB_URL = "jdbc:mysql://localhost:3306/math_trek";
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
            String query = "CREATE TABLE IF NOT EXISTS student(id INT PRIMARY KEY UNIQUE AUTO_INCREMENT, username VARCHAR(20), firstName VARCHAR(20), lastName VARCHAR(20), emailAddress VARCHAR(40), date_of_birth DATE, school_registration_number VARCHAR(55), image_file BLOB)";
            String query1 = "CREATE TABLE IF NOT EXISTS schools(id INT PRIMARY KEY UNIQUE AUTO_INCREMENT, school_name VARCHAR(55), district VARCHAR(20), school_registration_number VARCHAR(55), representative_name VARCHAR(20), representative_email VARCHAR(40))";
            String query2 = "CREATE TABLE IF NOT EXISTS applicants(id INT PRIMARY KEY UNIQUE AUTO_INCREMENT, username VARCHAR(20), firstName VARCHAR(20), lastName VARCHAR(20), emailAddress VARCHAR(40), date_of_birth DATE, school_registration_number VARCHAR(55), status VARCHAR(20))";
            String query3 = "CREATE TABLE IF NOT EXISTS participants(id INT PRIMARY KEY UNIQUE AUTO_INCREMENT, username VARCHAR(20), school_registration_number VARCHAR(55), status VARCHAR(10))";
            String query4 = "CREATE TABLE IF NOT EXISTS rejected(id INT PRIMARY KEY UNIQUE AUTO_INCREMENT, username VARCHAR(20), school_registration_number VARCHAR(55), status VARCHAR(10))";

            try {
                Statement statement = connection.createStatement();
                statement.execute(query);
                statement.execute(query1);
                statement.execute(query2);
                statement.execute(query3);
                statement.execute(query4);
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
                String date_of_birth, String school_registration_number, String image_file_path) {

            if (!isValidSchoolRegistrationNumber(school_registration_number)) {
                return "Error: Invalid school registration number. Registration denied.";
            }
            String query = "INSERT INTO student (username, firstName, lastName, emailAddress, date_of_birth, school_registration_number, image_file) VALUES (?, ?, ?, ?, ?, ?, ?)";

            try {
                PreparedStatement preparedStatement = connection.prepareStatement(query);
                preparedStatement.setString(1, username);
                preparedStatement.setString(2, firstName);
                preparedStatement.setString(3, lastName);
                preparedStatement.setString(4, emailAddress);
                preparedStatement.setString(5, date_of_birth);
                preparedStatement.setString(6, school_registration_number);

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

        public String loginStudent(String username, String schoolRegistrationNumber) {
            String query = "SELECT * FROM student WHERE username = ? AND school_registration_number = ?";
            try {
                PreparedStatement preparedStatement = connection.prepareStatement(query);
                preparedStatement.setString(1, username);
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

        public List<String> getPendingApplicants(String schoolRegistrationNumber) {
            List<String> pendingApplicants = new ArrayList<>();
            String query = "SELECT username FROM applicants WHERE status = 'pending' AND school_registration_number = ?";
            try {
                PreparedStatement preparedStatement = connection.prepareStatement(query);
                preparedStatement.setString(1, schoolRegistrationNumber);
                ResultSet resultSet = preparedStatement.executeQuery();
                while (resultSet.next()) {
                    String username = resultSet.getString("username");
                    pendingApplicants.add(username);
                }
                return pendingApplicants;
            } catch (SQLException e) {
                e.printStackTrace();
                System.out.println("Error retrieving pending applicants: " + e.getMessage());
            }
            return null;
        }

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

    }

    // END OF DATABASE METHODS
    // ...........................//

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

                    String response = myDbHelper.registerStudent(username, firstName, lastName, emailAddress,
                            date_of_birth, school_registration_number, image_file);
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
                        String schoolRegistrationNumber = in.readLine();

                        String loginResult = myDbHelper.loginStudent(username, schoolRegistrationNumber);
                        if (loginResult != null) {
                            out.println("Login Successful!");
                            System.out.println("Student login successful");
                            currentUsername = username;

                            // Providing student-specific commands
                            out.println("Available commands: viewChallenges");
                        } else {
                            out.println("Invalid username or school registration number. Login Failed");
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
                                    .println("Invalid representative name or school registration number. Login Failed");
                        }
                    } else {
                        out.println("Invalid user type selected. Please try again.");
                    }

                } else if (inputLine.equalsIgnoreCase("viewApplicants")) {
                    System.out.println(inputLine);
                    if (myDbHelper.isRepresentative(currentUsername)) {
                        System.out.println(currentUsername);
                        // We retrieve applicants whose status is 'pending' and school registration
                        // number matches
                        String schoolRegistrationNumber = myDbHelper.getSchoolRegistrationNumber(currentUsername);
                        List<String> pendingApplicants = myDbHelper.getPendingApplicants(schoolRegistrationNumber);

                        // We print our currentUsername and also print applicants which I use for
                        // debugging
                        System.out.println("Current username: " + currentUsername);
                        System.out.println("Pending applicants: " + pendingApplicants);

                        // We then send the list of pending applicants to the client
                        if (pendingApplicants != null && !pendingApplicants.isEmpty()) {
                            out.println("Pending Applicants: " + String.join(",", pendingApplicants));
                            System.out.println("Pending applicants sent to client: " + pendingApplicants);
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
                                out.println("Rejection successful for " + username);
                            } else {
                                out.println("Error rejecting " + username);
                            }
                        } else {
                            out.println("Invalid confirmation type. Use 'yes' or 'no'.");
                        }
                    } else {
                        out.println("Unauthorized access. Please login as a school representative.");
                    }
                } else {
                    out.println("Echo: " + inputLine);
                }
            }

        } catch (

        IOException e) {
            System.out.println(
                    "Exception caught when trying to listen on port " + portNumber + " or listening for a connection");
            System.out.println(e.getMessage());
        }

    }
}