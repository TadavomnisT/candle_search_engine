
import org.apache.lucene.analysis.standard.StandardAnalyzer;
import org.apache.lucene.document.Document;
import org.apache.lucene.document.Field;
import org.apache.lucene.document.StringField;
import org.apache.lucene.document.TextField;
import org.apache.lucene.index.DirectoryReader;
import org.apache.lucene.index.IndexReader;
import org.apache.lucene.index.IndexWriter;
import org.apache.lucene.index.IndexWriterConfig;
import org.apache.lucene.queryparser.classic.QueryParser;
import org.apache.lucene.search.IndexSearcher;
import org.apache.lucene.search.Query;
import org.apache.lucene.search.ScoreDoc;
import org.apache.lucene.search.TopScoreDocCollector;
import org.apache.lucene.store.FSDirectory;
import org.apache.lucene.util.Version;

import java.io.*;
import org.json.*;
import java.util.ArrayList;

public class Lucene_API {

    private static StandardAnalyzer analyzer = new StandardAnalyzer(Version.LUCENE_40);
    private IndexWriter writer;
    private ArrayList<File> queue = new ArrayList<File>();
    private static String indexPath = "./INDEX";
    

    public static void main(String[] args) throws IOException {
        String error_message = "Check input arguments.\n Usage: java Lucene_API switch{-query/-index} parameter(s){if using -index must be JSON-encoded} \n Examples: \n\t java Lucene_API -index {\"directories\":[\".\\/documents\"],\"files\":[],\"links\":[]} \n\t java Lucene_API -query \"PHP programming\"  ";
        Lucene_API indexer = new Lucene_API( indexPath );	

        try{
            if( args[0].equals("-index") ){
                if (  args[1].isEmpty()  ) {
                    System.out.println( error_message );
                    System.exit(0);
                }
                else {
                    String json_data = args[1];
                    // JSONObject jo = new JSONObject("{ \"abc\" : \"def\" }");
                    // System.out.println( json_data );
                    // System.exit(0);

                    
                    JSONObject jsonObject = new JSONObject(json_data);
                    JSONArray jsonarray = jsonObject.getJSONArray("files");
                    for (int i = 0; i < jsonarray.length(); i++) {
                        // System.out.println( jsonarray.getString(i) ); 
                        // System.exit(0);
                        indexer.indexFileOrDirectory( jsonarray.getString(i) );                       
                    }

                    jsonarray = jsonObject.getJSONArray("directories");
                    for (int i = 0; i < jsonarray.length(); i++) {
                        System.out.println(jsonarray.get(i));   
                        // I should do sth abot this                     
                    }

                    jsonarray = jsonObject.getJSONArray("links");
                    for (int i = 0; i < jsonarray.length(); i++) {
                        System.out.println(jsonarray.get(i));                        
                        // I should do sth abot this                     
                    }

                    indexer.closeIndex();

                }
            }
            else if( args[0].equals("-query") ){
                if (  args[1].isEmpty()  ) {
                    System.out.println( error_message );
                    System.exit(0);
                }
                else {
                    //Good to go - search for query

                    IndexReader reader = DirectoryReader.open(FSDirectory.open(new File(indexPath)));
                    IndexSearcher searcher = new IndexSearcher(reader);
                    TopScoreDocCollector collector = TopScoreDocCollector.create(20, true);
                    Query q = new QueryParser(Version.LUCENE_40, "contents", analyzer).parse(args[1]);		
                    searcher.search(q, collector);														
                    ScoreDoc[] hits = collector.topDocs().scoreDocs;									

                    // 4. display results
                    System.out.println("Found " + hits.length + " hits.");
                    for(int i=0;i<hits.length;++i) {
                    int docId = hits[i].doc;
                    Document d = searcher.doc(docId);
                    System.out.println((i + 1) + ". " + d.get("path") + " score=" + hits[i].score);
                    }

                }
            }
            else {
                System.out.println( error_message );
                System.exit(0);
            }
        }catch(Exception e){
           System.out.println(e);
           e.printStackTrace();
            System.out.println( error_message );
           System.exit(0);
        }

        

    }

    /**
    * Constructor
    * @param indexDir the name of the folder in which the index should be created
    * @throws java.io.IOException when exception creating index.
    */
    Lucene_API(String indexDir) throws IOException {
        // the boolean true parameter means to create a new index everytime, 
        // potentially overwriting any existing files there.
        FSDirectory dir = FSDirectory.open(new File(indexDir));
        IndexWriterConfig config = new IndexWriterConfig(Version.LUCENE_40, analyzer);
        writer = new IndexWriter(dir, config);
    }


      /**
   * Indexes a file or directory
   * @param fileName the name of a text file or a folder we wish to add to the index
   * @throws java.io.IOException when exception
   */
  public void indexFileOrDirectory(String fileName) throws IOException {
    //===================================================
    //gets the list of files in a folder (if user has submitted
    //the name of a folder) or gets a single file name (is user
    //has submitted only the file name) 
    //===================================================
    addFiles(new File(fileName));
    
    int originalNumDocs = writer.numDocs();
    for (File f : queue) {
      FileReader fr = null;
      try {
        Document doc = new Document();

        //===================================================
        // add contents of file
        //===================================================
        fr = new FileReader(f);
        doc.add(new TextField("contents", fr));
        doc.add(new StringField("path", f.getPath(), Field.Store.YES));
        doc.add(new StringField("filename", f.getName(), Field.Store.YES));

        writer.addDocument(doc);
        System.out.println("Added: " + f);
      } catch (Exception e) {
        System.out.println("Could not add: " + f);
      } finally {
        fr.close();
      }
    }
    
    int newNumDocs = writer.numDocs();
    System.out.println("");
    System.out.println("************************");
    System.out.println((newNumDocs - originalNumDocs) + " documents added.");
    System.out.println("************************");

    queue.clear();
  }

  private void addFiles(File file) {

    if (!file.exists()) {
      System.out.println(file + " does not exist.");
    }
    if (file.isDirectory()) {
      for (File f : file.listFiles()) {
        addFiles(f);
      }
    } else {
      String filename = file.getName().toLowerCase();
      queue.add(file);
    }
  }

  /**
   * Close the index.
   * @throws java.io.IOException when exception closing
   */
  public void closeIndex() throws IOException {
    writer.close();
  }

  
}



// ┌──(user㉿dhcppc4)-[~/Desktop/candle_search_engine/back-end/Java]
// └─$ javac -cp "./includes/lucene-analyzers-common-4.0.0.jar:includes/lucene-core-4.0.0.jar:includes/lucene-queryparser-4.0.0.jar:includes/json-20211205.jar" Lucene_API.java                                                             
                                                                                                                                                  
// ┌──(user㉿dhcppc4)-[~/Desktop/candle_search_engine/back-end/Java]
// └─$ java -cp .:includes/json-20211205.jar:includes/lucene-core-4.0.0.jar:includes/lucene-analyzers-common-4.0.0.jar:includes/lucene-queryparser-4.0.0.jar:includes/lucene-queryparser-4.0.0.jar Lucene_API -index "{\"directories\":[\".\/documents\"],\"files\":[],\"links\":[]}"
