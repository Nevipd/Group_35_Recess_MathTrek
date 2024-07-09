
// java client 127.0.0.1 5001
import java.io.*;
import java.net.*;

public class client {
    public static void main(String[] args) throws IOException {
        if (args.length != 2) {
            System.err.println(
                    "Usage: java client <host name> <port number>");
            System.exit(1);
        }

        String hostName = args[0];
        int portNumber = 5001;

        try (
                Socket mySocket = new Socket(hostName, portNumber);
                PrintWriter out = new PrintWriter(mySocket.getOutputStream(), true);
                BufferedReader in = new BufferedReader(
                        new InputStreamReader(mySocket.getInputStream()));
                BufferedReader stdIn = new BufferedReader(
                        new InputStreamReader(System.in))) {
            System.out.println("Enter command 'Register / Login / Exit to Close' ");
            String userInput;
            boolean isAuthenticated = false;

            while ((userInput = stdIn.readLine()) != null &&
                    !userInput.equalsIgnoreCase("Exit")) {
                if (!isAuthenticated) {
                    if (userInput.equalsIgnoreCase("register")) {
                        System.out.print("Enter username: ");
                        String username = stdIn.readLine();

                        System.out.print("Enter first name: ");
                        String firstName = stdIn.readLine();

                        System.out.print("Enter last name: ");
                        String lastName = stdIn.readLine();

                        System.out.print("Enter email: ");
                        String emailAddress = stdIn.readLine();

                        System.out.print("Enter date of birth(yyyy/mm/dd): ");
                        String date_of_birth = stdIn.readLine();

                        System.out.print("Enter school registration number: ");
                        String school_registration_number = stdIn.readLine();

                        System.out.print("Enter absolute path of the image file(C:\\Users\\...): ");
                        String image_file = stdIn.readLine();

                        out.println(userInput);
                        out.println(username);
                        out.println(firstName);
                        out.println(lastName);
                        out.println(emailAddress);
                        out.println(date_of_birth);
                        out.println(school_registration_number);
                        out.println(image_file);

                        String response = in.readLine();
                        if (response.startsWith("Error")) {
                            System.out.println("Server response: " + response);
                        } else {
                            System.out.println("Registration details sent. Please type login to continue.");
                        }

                    } else if (userInput.equalsIgnoreCase("login")) {

                        System.out.println("Are you a Student or School Representative?");
                        System.out.println(
                                "Enter 'student' for Student or 'representative' for School Representative: ");
                        String loginType = stdIn.readLine();

                        // Student login
                        if (loginType.equalsIgnoreCase("student")) {
                            System.out.print("Enter username: ");
                            String username = stdIn.readLine();

                            System.out.print("Enter school registration number: ");
                            String schoolRegistrationNumber = stdIn.readLine();

                            out.println(userInput);
                            out.println("student");
                            out.println(username);
                            out.println(schoolRegistrationNumber);

                        } else if (loginType.equalsIgnoreCase("representative")) {
                            System.out.print("Enter representative name: ");
                            String representativeName = stdIn.readLine();

                            System.out.print("Enter school registration number: ");
                            String schoolRegistrationNumber = stdIn.readLine();

                            out.println(userInput);
                            out.println("representative");
                            out.println(representativeName);
                            out.println(schoolRegistrationNumber);

                        } else {
                            System.out
                                    .println("Invalid login type. Please enter 'student' or 'representative'.");
                            break;
                        }

                        String response = in.readLine();
                        System.out.println("Server response: " + response);

                        if (response.startsWith("Login Successful!")) {
                            System.out.println("Login successful");
                            System.out.println("        ");

                            if (loginType.equalsIgnoreCase("Student")) {
                                System.out.println("######################################################");
                                System.out.println("Welcome to the School Students' System ");
                                System.out.println("          ");
                                System.out.println("Input a command of your choice like 'viewChallenges'");

                            } else if (loginType.equalsIgnoreCase("representative")) {
                                System.out.println("######################################################");
                                System.out.println("Welcome to the School Representatives' System ");
                                System.out.println("          ");
                                System.out.println("Input a command of your choice like 'viewApplicants'");
                            }
                            isAuthenticated = true;
                        } else if (response.equals("Invalid Username or School Registration Number. Login Failed")) {
                            System.out.println("Invalid Username or School Registration Number. Login Failed");
                        } else {
                            System.out.println("Login Failed, Try Again");
                        }
                    }
                } else if (isAuthenticated) {
                    if (userInput.equalsIgnoreCase("viewApplicants")) {
                        out.println(userInput);
                        String response = in.readLine();

                        if (response.startsWith("Pending Applicants:")) {
                            String applicantsString = response.substring("Pending Applicants:".length()).trim();
                            String[] applicants = applicantsString.split(",");

                            if (applicants.length > 0) {
                                System.out.println("Pending Applicants:");
                                for (String applicant : applicants) {
                                    System.out.println("-> " + applicant);
                                    System.out.println("  ");
                                }

                                // Ask for confirmation
                                System.out.println("Do you want to confirm or reject any applicant?");
                                System.out.println("Enter 'confirm <username>' or 'reject <username>':");

                                String confirmRejectInput = stdIn.readLine();
                                out.println(confirmRejectInput); // Send confirmation/rejection command to server

                                String confirmRejectResponse = in.readLine();
                                System.out.println("Server response: " + confirmRejectResponse);
                            } else {
                                System.out.println("No pending applicants found.");
                            }
                        } else {
                            System.out.println("Error fetching applicants: " + response);
                        }
                    }

                } else {
                    System.out.println("Unknown Command");
                    System.out.println(
                            "Available commands: 'login / register / exit' ");
                }

            }

        } catch (UnknownHostException e) {
            System.err.println("Don't know about host " + hostName);
            System.exit(1);
        } catch (IOException e) {
            System.err.println("Couldn't get I/O for the connection to " +
                    hostName);
            System.exit(1);
        }
    }
}
