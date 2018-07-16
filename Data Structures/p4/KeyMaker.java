import java.io.File;
import java.io.IOException;
import java.util.Scanner;
import java.util.StringTokenizer;

class KeyMaker {

	public enum States {
		START, SEQUENCE, UNKNOWN_CHARS, IN_SEQUENCE, END_SEQUENCE, END
	}

	States state = States.START;
	Scanner scan;
	BTree tree;
	File file;
	String filename;
	String line;
	String key;
	GeneBankCreateBTree create;
	int currentChar;

	KeyMaker(GeneBankCreateBTree create) throws IOException {
		this.create = create;
		filename = (create.getFile().getName() + ".btree.data." + create.getSequenceLength() + "." + create.getDegree());
		file = create.getFile();
		tree = new BTree(create.getDegree(), create.getFile());
		scan = new Scanner(create.getFile());
		currentChar = 0;

	}

	long getNextKey() throws Exception{
		long finalKey = 0;
		while(finalKey == 0 && state != States.END){
			finalKey = genNext();
		}
		return 0;
		}
	private long genNext() throws Exception {
		
		switch (state) {

		case START: {
			start();
			
			break;
		}
		case SEQUENCE: {
			sequence();
			
			break;
		}
		case IN_SEQUENCE: {
			buildSequence();
			
			break;

		}
		case UNKNOWN_CHARS: {
			unknownChar();
			state = States.SEQUENCE;
			break;
		}

		case END_SEQUENCE: {
			endSequence();
			break;
		}
		case END:
			break;
		default:
			break;
		}
		//returns if key is not complete
		return 0;
	}
	private void start(){
		key = "";
		while (state == States.START) {
			while(scan.hasNextLine()){
				line = scan.nextLine();
			
			if (line == null) {
				state = States.END;
				break;

			} else if (line.contains("ORIGIN")) {
				state = States.SEQUENCE;
				break;
			}
			}
		}
	}
	
	private String sequence(){
		while (state == States.SEQUENCE) {
			
			String ch = scan.next();
			StringTokenizer token = new StringTokenizer(ch);
			if(Character.isDigit(ch.charAt(0))){
				ch = scan.next();
			}

			if (ch.charAt(currentChar) == '/') {
				state = States.END_SEQUENCE;
				break;
			} else if (ch.charAt(currentChar) == 'n') {

				state = States.UNKNOWN_CHARS;
				break;
			} else if (ch.contains("a") || ch.contains("t") || ch.contains("c") || ch.contains("g")) {
				if (key.length() == create.getSequenceLength()) {
					key = key.substring(1, create.getSequenceLength());
					key += ch;
				} else {

					key += ch;
					if (key.length() == create.getSequenceLength()) {

						
					}
				}
			}

		}
		return "";
	}
	
	private void buildSequence(){
		while (state == States.IN_SEQUENCE) {

			String ch = scan.next();
			if (ch.contains("/")) {

				state = States.END_SEQUENCE;
			} else if (ch.contains("a") || ch.contains("t") || ch.contains("c") || ch.contains("g")) {
				key += ch;
				state = States.SEQUENCE;
				break;
			}
		}
	}
	private void unknownChar(){
		
	}
	private void endSequence(){
		while(state == States.END_SEQUENCE){
			line = scan.nextLine();
			if (line != null) {

				line.trim();
				if (line.equals("ORIGIN")) {

					state = States.SEQUENCE;
					break;
				}
			} else {
				state = States.END;
				break;
			}
			}
	
	}
	
	private long encode(String seq) throws Exception {
		if (seq.length() != create.getSequenceLength()) {
			throw new Exception("String of length " + seq.length() + " was passed to btree with sequenceLenght of "
					+ create.getSequenceLength());
		}
		long sequence = 0;
		for (int i = 0; i < seq.length(); i++) {
			sequence = sequence << 2;
			char c = seq.charAt(i);
			if (c == 'a' || c == 'A') {
				sequence = sequence | 0x0L;
			} else if (c == 't' || c == 'T') {
				sequence = sequence | 0x3L;
			} else if (c == 'c' || c == 'C') {
				sequence = sequence | 0x1L;
			} else if (c == 'g' || c == 'G') {
				sequence = sequence | 0x2L;
			} else {
				throw new Exception("Unexpected character: " + c);
			}
		}
		return sequence;
	}
}
