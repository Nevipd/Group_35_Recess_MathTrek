
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
                        // String username = stdIn.readLine();

                        // System.out.print("Enter contact: ");
                        // String contact = stdIn.readLine();

                        // System.out.print("Enter password: ");
                        // String password = stdIn.readLine();

                        // out.println(userInput);
                        // out.println(username);
                        // out.println(contact);
                        // out.println(password);

                        // String response = in.readLine();
                        // System.out.println("Please save this member number somewhere with you: " +
                        // response);

                        // System.out.println("Registration details sent. Please login.");

                        // } else if (userInput.equalsIgnoreCase("login")) {
                        // System.out.print("Enter username: ");
                        // String username = stdIn.readLine();

                        // System.out.print("Enter password: ");
                        // String password = stdIn.readLine();

                        // out.println(userInput);
                        // out.println(username);
                        // out.println(password);
                        // String response = in.readLine();
                        // System.out.println("Server response: " + response);

                        // if (response.equals("Login Successful!")) {
                        // System.out.println("Login successful");
                        // System.out.println(
                        // "Input a command of your choice 'Deposit / CheckStatement/ requestLoan/
                        // LoanRequestStatus'");
                        // isAuthenticated = true;
                        // } else if (response.equals("Invalid Username or Password. Login Failed")) {
                        // loginAttempts++;

                        // if (loginAttempts >= 3) {
                        // System.out.println(
                        // "Login failed. You have reached the maximum number of login attempts.");
                        // System.out.println("Initiating password recovery...");
                        // String response1 = in.readLine();
                        // System.out.println("Server response: " + response1);
                        // System.out.print("Enter member number: ");
                        // String memberNumber = stdIn.readLine();

                        // System.out.print("Enter phone number: ");
                        // String phoneNumber = stdIn.readLine();

                        // out.println("recoverPassword");
                        // out.println(memberNumber);
                        // out.println(phoneNumber);

                        // String recoverPasswordResponse = in.readLine();
                        // System.out.println("Server response: " + recoverPasswordResponse);
                        // break;
                        // }
                        // }
                        // } else {
                        // System.out.println("You need to log in or register to access this command.");
                        // }

                        // } else {
                        // if (userInput.equalsIgnoreCase("deposit")) {

                        // out.println(userInput);
                        // System.out.print("Enter amount of money you want deposited: ");
                        // double amount = Double.parseDouble(stdIn.readLine());

                        // System.out.print("Enter Receipt Number of Deposit: ");
                        // int receipt_no = Integer.parseInt(stdIn.readLine());

                        // System.out.print("Enter Date Deposited In the Format yyyy-mm-dd: ");
                        // String dateDeposited = stdIn.readLine();

                        // out.println(amount);
                        // out.println(receipt_no);
                        // out.println(dateDeposited);

                        // String response = in.readLine();

                        // if (response.startsWith("Deposit Successful!")) {
                        // System.out.println(response);
                        // System.out.println(
                        // "Input a command of your choice 'Deposit / CheckStatement/ requestLoan/
                        // LoanRequestStatus'");
                        // } else if (response.equals("Error: Receipt number already exists.")) {
                        // System.out.println("Error: You have entered a duplicate receipt number.
                        // Please try again.");
                        // } else {
                        // System.out.println("Deposit failed. Please try again.");
                        // }

                        // } else if (userInput.equalsIgnoreCase("requestLoan")) {

                        // System.out.print("Enter amount of loan needed: ");
                        // double loan_amount = Double.parseDouble(stdIn.readLine());

                        // System.out.print("Enter the payment period in months: ");
                        // int payment_period = Integer.parseInt(stdIn.readLine());

                        // out.println(userInput);
                        // out.println(loan_amount);
                        // out.println(payment_period);

                        // String response = in.readLine();
                        // if (response.startsWith("Insufficient funds")) {
                        // System.out.println(response);

                        // } else if (response.startsWith("Error: Loan amount")) {
                        // System.out.println(response);

                        // } else if (response.startsWith("Error: You have already requested")) {
                        // System.out.println(response);

                        // } else {
                        // System.out.println(
                        // "Loan request submited, Take the loan application number and save it for
                        // further reference");
                        // System.out.println("Loan application number: " + response);
                        // }
                        // } else if (userInput.equalsIgnoreCase("LoanRequestStatus")) {
                        // System.out.print("Enter the loan application number: ");
                        // String loan_application_number = stdIn.readLine();
                        // out.println(userInput);
                        // out.println(loan_application_number);

                        // String response = in.readLine();

                        // if (response.startsWith("Pending")) {
                        // System.out.println(response);
                        // } else {
                        // System.out.println("Error! Incorrect loan application number");
                        // }

                        // } else if (userInput.equalsIgnoreCase("checkStatement")) {
                        // System.out.print("Enter start date of statement In the Format yyyy-mm-dd: ");
                        // String startDate = stdIn.readLine();

                        // System.out.print("Enter end date of statement In the Format yyyy-mm-dd: ");
                        // String endDate = stdIn.readLine();

                        // out.println(userInput);
                        // out.println(startDate);
                        // out.println(endDate);
                    } else {
                        System.out.println("Unknown Command");
                        System.out.println(
                                "Available commands: 'Deposit / CheckStatement/ requestLoan/LoanRequestStatus'");
                    }

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
