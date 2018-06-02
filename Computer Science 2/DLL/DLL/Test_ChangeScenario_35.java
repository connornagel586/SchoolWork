



import org.testng.annotations.BeforeMethod;
import org.testng.annotations.DataProvider;
import org.testng.annotations.Parameters;
import org.testng.annotations.Test;


/**
 * Testing for IndexedUnorderedList interface implementation: 
 * Tests for Change Scenario 35: [A, B, C] -> remove(B) -> [A, C] 
 * @author Connor Nagel
 *
 */
public class Test_ChangeScenario_35 {
private IndexedUnorderedList<Integer> list;
	
	//****** Constants used in tests *****************
		// Elements in the list
		private static final Object[][] VALID_ELEMENTS = { {TestCase.A},{TestCase.C}};
		// First element in list
		private static final Integer FIRST = TestCase.A;
		// Last element in list 
		private static final Integer LAST = TestCase.C;	
		// Elements in list with indexes
		private static final Object[][] INDEXED_VALID_ELEMENTS = { {0, TestCase.A},{1, TestCase.C} };
		// Valid indexes to elements in list 
		private static final Object[][] VALID_INDEXES = { {0}, {1} };
		// Invalid indexes outside of list 
		private static final Object[][] INVALID_INDEXES = { {-1}, {2} };
		// Valid indexes where can add a new element 
		private static final Object[][] VALID_ADD_INDEXES = { {0}, {1}, {2} }; 
		// Invalid indexes outside range of where can add elements
		private static final Object[][] INVALID_ADD_INDEXES = { {-1}, {3} };
		// Size of the list 
		private static final int SIZE = 2; 	
	
	//****** Don't change these constants *****************
		// An element not in list 
		private static final Integer ELEMENT = TestCase.E; 
		// Another element not in list - used for negative testing 
		private static final Integer INVALID_ELEMENT = TestCase.F;

	//********************Before Each Test********************
	/**
	 * Sets up list for testing: uses Parameter in .xml file to select the 
	 * dynamic type of the list. 
	 * @param listType - String representing the dynamic type of the list. 
	 */
	@BeforeMethod
	@Parameters("listType")
	public void initialize(String listType)
	{
		list = TestCase.newList(listType);
		list.addToFront(TestCase.C);
		list.addToFront(TestCase.B);
		list.addToFront(TestCase.A);
		list.remove(TestCase.B);
		
	}
	
	//******************* Tests ***************************
	/**
	 * Test: removeFirst() - remove first element of list
	 * Expected Result: Reference to first element (A) 
	 */
	@Test
	public void testRemoveFirst()
	{
		TestCase.removeFirst(list, FIRST);
	}

	/**
	 * Test: removeLast() - remove last element of list 
	 * Expected Result: Reference to last element (C)
	 */
	@Test
	public void testRemoveLast()
	{
		TestCase.removeLast(list, LAST);
	}
    
	/**
	 * Test: remove(X) - remove elements X from list 
	 * Expected Result: Reference to elements X 
	 */
	@Test(dataProvider = "validElements")
	public void testRemove_validElement(Integer element)
	{
		TestCase.remove(list, element);
	}
	
	/**
	 * Test: remove(INVALID_ELEMENT) - tries to remove an invalid element (F) from list 
	 * Expected Result: ElementNotFoundException
	 */
	@Test(expectedExceptions = ElementNotFoundException.class)
	public void testRemove_invalidElement()
	{
		TestCase.remove(list, INVALID_ELEMENT);
	}
	
	/**
	 * Test: first() - returns reference to first element 
	 * Expected Result: Reference to first element (A) 
	 */
	@Test
	public void testFirst()
	{
		TestCase.first(list, FIRST);
	}

	/**
	 * Test: last() - returns reference to last element 
	 * Expected Result: Reference to last element (C) 
	 */
	@Test
	public void testLast()
	{
		TestCase.last(list, LAST);
	}

	/**
	 * Test: contains(X) - whether list contains valid elements X  
	 * Expected Result: true
	 */
	@Test(dataProvider = "validElements")
	public void testContains_validElement(Integer element)
	{
		TestCase.contains(list, element, true);
	}
	
	/**
	 * Test: contains(INVALID_ELEMENT) - whether list contains invalid element (F)  
	 * Expected Result: false
	 */
	@Test
	public void testContains_invalidElement()
	{
		TestCase.contains(list, INVALID_ELEMENT, false);
	}

	/**
	 * Test: isEmpty() - whether list is empty 
	 * Expected Result: false
	 */
	@Test
	public void testIsEmpty()
	{
		TestCase.isEmpty(list, false);
	}

	/**
	 * Test: size() - number of elements in list  
	 * Expected Result: SIZE (2)
	 */
	@Test
	public void testSize()
	{
		TestCase.size(list, SIZE);
	}

	/**
	 * Test: iterator() - an Iterator object 
	 * Expected Result: Reference to Iterator object  
	 */
	@Test
	public void testIterator()
	{
		TestCase.iterator(list);
	}

	/**
	 * Test: addToFront(ELEMENT) - adds element (E) to front of list  
	 * Expected Result: No Exception 
	 */
	@Test
	public void testAddToFront()
	{
		TestCase.addToFront(list, ELEMENT);
	}

	/**
	 * Test: addToRear(E) - adds element (E) to back of list  
	 * Expected Result: No Exception 
	 */
	@Test
	public void testAddToRear()
	{
		TestCase.addToRear(list, ELEMENT);
	}

	/**
	 * Test: addAfter(E, X) - adds element (E) after elements X in the list  
	 * Expected Result: No Exception
	 */
	@Test(dataProvider = "validElements")
	public void testAddAfter_validElement(Integer element)
	{
		TestCase.addAfter(list, ELEMENT, element);
	}
	
	/**
	 * Test: addAfter(ELEMENT, INVALID_ELEMENT) - tries to add element (E) after an invalid element (F) in the list  
	 * Expected Result: ElementNotFoundException
	 */
	@Test(expectedExceptions = ElementNotFoundException.class)
	public void testAddAfter_invalidElement()
	{
		TestCase.addAfter(list, ELEMENT, INVALID_ELEMENT);
	}
	
	/**
	 * Test: add(X, ELEMENT) - adds ELEMENT (E) at valid indexes X   
	 * Expected Result: No Exception
	 */
	@Test(dataProvider = "validAddIndexes")
	public void testAdd_validIndex(int index)
	{
		TestCase.add(list, index, ELEMENT);
	}
	
	/**
	 * Test: add(X, ELEMENT) - tries to add ELEMENT (E) at invalid indexes X   
	 * Expected Result: IndexOutOfBoundsException
	 */
	@Test(dataProvider = "invalidAddIndexes", expectedExceptions = IndexOutOfBoundsException.class)
	public void testAdd_invalidIndex(int index)
	{
		TestCase.add(list, index, ELEMENT);
	}
	
	/**
	 * Test: remove(X) - removes elements at valid indexes X   
	 * Expected Result: Reference to elements at valid indexes X 
	 */
	@Test(dataProvider = "indexedValidElements")
	public void testRemove_validIndex(int index, Integer element)
	{
		TestCase.remove(list, index, element);
	}

	/**
	 * Test: remove(X) - tries to remove element at invalid indexes X   
	 * Expected Result: IndexOutOfBoundsException
	 */
	@Test(dataProvider = "invalidIndexes", expectedExceptions = IndexOutOfBoundsException.class)
	public void testRemove_invalidIndex(int index)
	{
		TestCase.remove(list, index, ELEMENT);
	}
	
	/**
	 * Test: set(X, ELEMENT) - sets value of element at valid indexes X to element (E)    
	 * Expected Result: No Exception
	 */
	@Test(dataProvider = "validIndexes")
	public void testSet_validIndex(int index)
	{
		TestCase.set(list, index, ELEMENT);
	}

	/**
	 * Test: set(X, ELEMENT) - tries to set value of element at invalid indexes X to element (E)    
	 * Expected Result: IndexOutOfBoundsException
	 */
	@Test(dataProvider = "invalidIndexes", expectedExceptions = IndexOutOfBoundsException.class)
	public void testSet_invalidIndex(int index)
	{
		TestCase.set(list, index, ELEMENT);
	}

	/**
	 * Test: get(X) - reference to element at valid indexes X   
	 * Expected Result: Reference to element at valid indexes X
	 */
	@Test(dataProvider = "indexedValidElements")
	public void testGet_validIndex(int index, Integer element)
	{
		TestCase.get(list, index, element);
	}

	/**
	 * Test: get(X) - tries to return reference to element at invalid indexes X   
	 * Expected Result: IndexOutOfBoundsException
	 */
	@Test(dataProvider = "invalidIndexes", expectedExceptions = IndexOutOfBoundsException.class)
	public void testGet_invalidIndex(int index)
	{
		TestCase.get(list, index, ELEMENT);
	}

	/**
	 * Test: indexOf(X) - returns index of valid elements X   
	 * Expected Result: Index of elements X 
	 */
	@Test(dataProvider = "indexedValidElements")
	public void testIndexOf(int index, Integer element)
	{
		TestCase.indexOf(list, index, element);
	}

	/**
	 * Test: indexOf(INVALID_ELEMENT) - tries to return index of element invalid element (F)   
	 * Expected Result: -1 (not found) 
	 */
	@Test
	public void testIndexOf()
	{
		TestCase.indexOf(list, -1, INVALID_ELEMENT);
	}
	
	//********** Data Providers ***************************
	/**
	 * Data: Integer element.
	 *    
	 * @return 2D array of Integer elements and Strings 
	 */
	   @DataProvider
	   public static Object[][] validElements() 
	   {
	      return VALID_ELEMENTS; 
	   }
	   
		/**
		 * Data: index of an element, and the Integer element at that location.
		 * 
		 * @return 2D array of indexes, Integer elements at that index and 
		 *  Strings
		 */
	   @DataProvider
	   public static Object[][] indexedValidElements() 
	   {
	      return INDEXED_VALID_ELEMENTS; 
	   }

	   /**
	    * Data: Two indexes: -1 and index 1 past last element in list. 
	    *  
	    * @return 2D array (second dimension empty) indexes outside of the list
	    */
	   @DataProvider
	   public static Object[][] invalidIndexes() 
	   {
	      return INVALID_INDEXES; 
	   }
	   
	   /**
	    * Data: All indexes of elements in the list. 
	    * 
	    * @return 2D array (second dimension empty) indexes of elements 
	    * in the list 
	    */
	   @DataProvider
	   public static Object[][] validIndexes() 
	   {
	      return VALID_INDEXES; 
	   }
	
	   /**
	    * Data: Indexes where elements can be added.
	    * 
	    * @return 2D array (second dimension empty) indexes of list
	    * where elements can be added.
	    * Note: can add element one past the last element in the list.  
	    */
	   @DataProvider
	   public static Object[][] validAddIndexes() 
	   {
	      return VALID_ADD_INDEXES; 
	   }

	   /**
	    * Data: Two indexes: -1 and index 2 past last element in the list. 
	    * 
	    * @return 2D array (second dimension empty) indexes of list
	    * where elements can't be added. 
	    * Note: can add element one past the last element in the list,
	    * so first invalid index is two past this element. 
	    */
	   @DataProvider
	   public static Object[][] invalidAddIndexes() 
	   {
	      return INVALID_ADD_INDEXES;
	   }

}

