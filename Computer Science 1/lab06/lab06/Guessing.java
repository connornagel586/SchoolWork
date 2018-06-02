package lab06;
import java.util.*;

/**
 * Demonstrates the use of a block statement in an if-else.
 *
 * @author Java Foundations
 */
public class Guessing
{
	/**
	 * Plays a simple guessing game with the user.
	 * @param args
	 */
	public static void main(String[]args)
	{
		final int MAX = 10;
		int answer, guess;

		Scanner scan = new Scanner(System.in);
		Random generator = new Random();

		answer = generator.nextInt(MAX) + 1;

		System.out.print("I'm thinking of a number between 1 and "
				+MAX + ". Guess what it is: ");


		do{
			System.out.print("Guess: ");
			guess = scan.nextInt();

			if (guess == answer)
			{
				System.out.println("You got it! Good guessing!");
			}

			else
			{
				if(guess > MAX || guess < 1){
					System.out.println("Number is out of range.");
				}
				else if(guess > answer){
					System.out.println("Lower");
				}
				else{
					System.out.println("Higher");
			}
			
			}
		}while(guess != answer);

	scan.close();
}
}