import java.io.File;
import java.io.IOException;
import java.util.Scanner;

class KeyMaker {

	public enum States {
		START, SEQUENCE, UNKNOWN_CHARS, END_SEQUENCE, END
	}

	private States state = States.START;
	Scanner scan;
	private String line;
	private String key;
	private String ch;
	
	BTree tree;
	File file;
	String filename;
	GeneBankCreateBTree create;
	int currentChar;

	KeyMaker(GeneBankCreateBTree create) throws IOException {
		this.create = create;
		filename = (create.getFile().getName() + ".btree.data." + create.getSequenceLength() + "." + create.getDegree());
		file = create.getFile();
		tree = new BTree(create.getDegree(), create.getFile());
		scan = new Scanner(create.getFile()).useDelimiter("\\s*");
		currentChar = 0;
		ch = "";
	}

	long getNextKey() throws Exception{
		long finalKey = 0;
		while(finalKey == 0 && state != States.END){
			finalKey = genNext();
		}
		return finalKey;
		}
	private long genNext() throws Exception {
		
		switch (state) {

		case START: {
			start();
			
			break;
		}
		case SEQUENCE: {
			String seq = sequence();
			if(seq != ""){
				key = "";
				return encode(seq);
			}
	
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
			while(scan.hasNextLine()){
				line = scan.nextLine();
			
			if (line == null) {
				state = States.END;
				break;

			} else if (line.contains("ORIGIN")) {
				state = States.SEQUENCE;
				ch = scan.next();
				break;
			}
			}
		
	}
	
	private String sequence(){
			if(Character.isDigit(ch.charAt(0))){
				ch = scan.next();
			}

			if (ch.charAt(currentChar) == '/') {
				state = States.END_SEQUENCE;
				
			} else if (ch.charAt(currentChar) == 'n') {

				state = States.UNKNOWN_CHARS;
				
			} else if (ch.charAt(currentChar) == 'a' || ch.charAt(currentChar) == 't' || ch.charAt(currentChar) == 'c' || ch.charAt(currentChar) == 'g') {
				if (key.length() == create.getSequenceLength() - 1) {
				
					key += ch.charAt(currentChar);
					currentChar = currentChar - (create.getSequenceLength() - 2);
					System.out.println(key);
					return key;
				} else {
					
					key += ch.charAt(currentChar);
					currentChar++;
					
					if(currentChar == ch.length()){
						ch = scan.next();
						currentChar = 0;
					}
			
				}
			
			}

		
		return "";
	}
	
	private void unknownChar(){
		while(ch.charAt(currentChar) != 'a' || ch.charAt(currentChar) != 't' || ch.charAt(currentChar) != 'c' || ch.charAt(currentChar) != 'g'){
			if(ch.charAt(currentChar) == '/'){
				state = States.END_SEQUENCE;
			}
			else if(currentChar < ch.length())
			{
				currentChar++;
			}else{
				currentChar = 0;
				ch = scan.next();
			}
		}
	}
	private void endSequence(){
		
			line = scan.nextLine();
			if (line == null) {
				state = States.END;
			}
				line.trim();
				if (line.contains("ORIGIN")) {
					state = States.SEQUENCE;
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
