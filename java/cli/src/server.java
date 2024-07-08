// Javac server.java client.java
// java -cp .;.\mysql-connector-j-8.0.31.jar server.java 5001

import java.net.*;
import java.io.*;
import java.sql.*;

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
            String query = "CREATE TABLE IF NOT EXISTS student(id INT PRIMARY KEY UNIQUE AUTO_INCREMENT, username VARCHAR(20) firstName VARCHAR(20), lastName VARCHAR(20) emailAddress VARCHAR(), date_of_birth DATE, school_registration_number VARCHAR(55), image_file BLOB)";

            try {
                Statement statement = connection.createStatement();
                statement.execute(query);
            } catch (SQLException e) {
                e.printStackTrace();
            }
        }

        public String registerStudent(String username, String firstName, String lastName, String emailAddress,
                String date_of_birth, String school_registration_number, String image_file_path) {
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
                FileInputStream fis = new FileInputStream(imageFile);
                preparedStatement.setBinaryStream(7, fis, (int) imageFile.length());

                preparedStatement.executeUpdate();

                System.out.println("Registration successful!");
                return "Registration successful!";
            } catch (SQLException | FileNotFoundException e) {
                e.printStackTrace();
                System.out.println("Error registering user: " + e.getMessage());
                return null;
            }
        }

    }

    // END OF DATABASE METHODS
    // ...........................//

    public static void main(String[] args) {
        if (args.length != 1) {
            System.err.println("Usage: java EchoServer <port number>");
            System.exit(1);
        }
        int portNumber = Integer.parseInt(args[0]);

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
                } else {
                    out.println("Echo: " + inputLine);
                }
            }

        } catch (IOException e) {
            System.out.println(
                    "Exception caught when trying to listen on port " + portNumber + " or listening for a connection");
            System.out.println(e.getMessage());
        }

    }
}