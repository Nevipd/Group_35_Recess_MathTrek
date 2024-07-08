// Javac server.java client.java
// java -cp .;.\mysql-connector-j-8.0.31.jar server.java 5001

import java.net.*;
import java.io.*;
import java.sql.*;
import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.HashSet;
import java.util.List;
import java.util.Map;
import java.util.Random;
import java.util.Set;
import java.text.SimpleDateFormat;
import java.time.LocalDateTime;

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
            String query = "CREATE TABLE IF NOT EXISTS student(id INT PRIMARY KEY UNIQUE AUTO_INCREMENT, member_number VARCHAR(20), username VARCHAR(55), contact VARCHAR(55), password VARCHAR(55))";

            try {
                Statement statement = connection.createStatement();
                statement.execute(query);
            } catch (SQLException e) {
                e.printStackTrace();
            }
        }

        // public String registerUser(String username, String contact, String password)
        // {
        // String query = "INSERT INTO member (username, member_number, contact,
        // password) VALUES (?, ?, ?, ?)";
        // String memberNumber = generateMemberNumber();
        // try {
        // PreparedStatement preparedStatement = connection.prepareStatement(query);
        // preparedStatement.setString(1, username);
        // preparedStatement.setString(2, memberNumber);
        // preparedStatement.setString(3, contact);
        // preparedStatement.setString(4, password);
        // preparedStatement.executeUpdate();
        // System.out.println("Registration successful!..... Member number: " +
        // memberNumber);
        // return memberNumber;
        // } catch (SQLException e) {
        // e.printStackTrace();
        // System.out.println("Error registering user: " + e.getMessage());
        // return null;
        // }
        // }

    }

    // END OF DATABASE METHODS //
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

        } catch (IOException e) {
            System.out.println(
                    "Exception caught when trying to listen on port " + portNumber + " or listening for a connection");
            System.out.println(e.getMessage());
        }

    }
}