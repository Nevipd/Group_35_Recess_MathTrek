
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
            System.out.println("  ");
            System.out.println("Enter any of the commands to continue \n-->Register \n-->Login \n-->Exit to Close ");
            System.out.println("   ");
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

                        System.out.println("Are you a Student or School Representative?\n");
                        System.out.println(
                                "-->student (if you are a student) \n-->representative (if you are a school representative):\n ");
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
                                System.out.println("\n######################################################\n");
                                System.out.println("WELCOME TO THE SCHOOL STUDENTS SYSTEM ");
                                System.out.println("          ");
                                System.out.println(
                                        "Menu of current commands to procced \n-->viewChallenges \n-->Exit \n");

                            } else if (loginType.equalsIgnoreCase("representative")) {
                                System.out.println("\n######################################################\n");
                                System.out.println("WELCOME TO THE SCHOOL REPRESENTATIVES SYSTEM ");
                                System.out.println("          ");
                                System.out.println(
                                        "Menu of current commands to procced \n-->viewApplicants \n-->Exit \n");
                            }
                            isAuthenticated = true;
                        } else if (response.equals("Invalid Username or School Registration Number. Login Failed")) {
                            System.out.println("Invalid Username or School Registration Number. Login Failed");
                        } else {
                            System.out.println(
                                    "Login Failed \nMenu of commands to try again \n-->Login \n-->Register \n-->Exit");
                        }
                    } else {
                        System.out.println("Unknown Command\n");
                        System.out.println(
                                "The available menu commands are \n-->login \n-->register \n-->exit' ");
                    }
                } else if (isAuthenticated) {
                    if (userInput.equalsIgnoreCase("viewApplicants")) {
                        out.println(userInput);
                        String response = in.readLine();

                        if (response.startsWith("Pending Applicants:")) {
                            String applicantsString = response.substring("Pending Applicants:".length()).trim();
                            String[] applicants = applicantsString.split(",");

                            if (applicants.length > 0) {
                                System.out.println(
                                        "\nBelow are your current pending applicants' details of your school :\n");
                                System.out.println(
                                        "+-----------------+-----------------+-----------------+-----------------+-----------------+-----------------------------+-----------------+");
                                System.out.println(
                                        "| Username        | First Name      | Last Name       | Email Address   | Date of Birth   | School Registration Number  | Status          |");
                                System.out.println(
                                        "+-----------------+-----------------+-----------------+-----------------+-----------------+-----------------------------+-----------------+");
                                for (String applicantDetails : applicants) {
                                    String[] details = applicantDetails.split("\\|");
                                    System.out.printf("| %-15s | %-15s | %-15s | %-15s | %-15s | %-27s | %-15s |\n",
                                            details[0], details[1], details[2], details[3], details[4], details[5],
                                            details[6]);
                                }
                                System.out.println(
                                        "+-----------------+-----------------+-----------------+-----------------+-----------------+-----------------------------+-----------------+\n");
                                System.out.println("Menu of commands to proceed \n-->Confirm \n-->Exit");
                            } else {
                                System.out.println("No pending applicants found.\n");
                            }
                        } else {
                            System.out.println("Error fetching applicants: " + response);
                        }
                    } else if (userInput.equalsIgnoreCase("confirm")) {
                        System.out.println("      ");
                        System.out.println("Menu of current commands to proceed with applicants\n");
                        System.out.println(
                                "--->yes (to confirm) \n--->no (to reject) \n-->exit(to exit): \n");
                        String confirmType = stdIn.readLine();

                        if (confirmType.startsWith("yes")) {
                            System.out.println("Enter student's username: ");
                            String username = stdIn.readLine();

                            out.println(userInput);
                            out.println("yes");
                            out.println(username);

                            String response = in.readLine();
                            if (response.startsWith("Confirmation successful for")) {
                                System.out.println(response);
                                System.out.println("      ");
                                System.out.println("Menu of commands to proceed \n-->Confirm \n-->Exit if done\n");
                            } else {
                                System.out.println(response);
                                System.out.println("      ");
                                System.out.println("FAILED : TRY AGAIN again\n");
                                System.out.println("Menu of commands to proceed \\n" + //
                                        "-->Confirm \\n" + //
                                        "-->Exit if done\\n" + //
                                        "");
                            }

                        } else if (confirmType.startsWith("no")) {
                            System.out.println("Enter student's username: ");
                            String username = stdIn.readLine();

                            out.println(userInput);
                            out.println("no");
                            out.println(username);

                            String response = in.readLine();

                            if (response.startsWith("You have rejected")) {
                                System.out.println(response);
                                System.out.println("      ");
                                System.out.println("Menu of commands to proceed \n-->Confirm \n-->Exit if done\n");
                            } else {
                                System.out.println(response);
                                System.out.println("      ");
                                System.out.println("FAILED : TRY AGAIN again\n");
                                System.out.println("Menu of commands to proceed \n-->Confirm \n-->Exit if done\\n");
                            }

                        } else {
                            System.out.println("\nInvalid choice. \nMenu options are only \n-->yes \n-->no");
                        }

                    } else if (userInput.equalsIgnoreCase("viewChallenges")) {
                        out.println(userInput);
                        String response = in.readLine();

                        if (response.startsWith("You are currently pending")) {
                            System.out.println(response);
                            System.out.println("      ");
                            System.out.println("Menu of commands to proceed \n-->viewChallenges \n-->Exit if done");
                        } else if (response.startsWith("You are currently confirmed")) {
                            System.out.println(response);
                            System.out.println("      ");
                            System.out.println("Menu of commands to proceed \n-->attemptChallenges \n-->Exit");
                        } else if (response.startsWith("You are currently rejected")) {
                            System.out.println(response);
                            System.out.println("      ");
                            System.out.println("Menu of commands to proceed \n-->Exit");
                            break;
                        } else {
                            System.out.println(response);
                            System.out.println("      ");
                            System.err.println("FAILED TRY AGAIN");
                            break;
                        }
                    } else {
                        System.out.println(
                                "\nInvalid choice. \nMenu options are only \n-->viewApplicants \n-->confirm \n-->exit");
                    }

                } else {
                    System.out.println("\nYou are not authenticated to access this command\n");
                    System.out.println(
                            "The available menu commands are \n-->login \n-->register \n-->exit' ");
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
