using Ionic.Zip;
//using Code7248.word_reader;
//using Microsoft.Office.Interop.Word;
using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Xml;
using System.IO.Packaging;

using System.ComponentModel;
using System.Data;
using System.Drawing;

namespace SearchEngine
{
    class FileReader
    {
        private string text{get; set;}
        private string path { get; set; }
        public FileReader(string path)
        {
        //konstruktor file reader
            text = "";
            this.path = path;
            Console.WriteLine(path);
            string type = getExtension(path);

            if (type != null)
            {
                if ((type.CompareTo("docx") == 0))
                {
                    ReadDocx();
                    //Console.WriteLine(path);
                }
                else
                if ((type.CompareTo("txt") == 0) || (type.CompareTo("cpp") == 0)
                   || (type.CompareTo("cc") == 0) || (type.CompareTo("cs") == 0)
                    || (type.CompareTo("java") == 0) 
                     || (type.CompareTo("pas") == 0)
                    || (type.CompareTo("c") == 0)
                    || (type.CompareTo("doc") == 0)
                    || (type.CompareTo("html") == 0)
                    || (type.CompareTo("htm") == 0)
                    || (type.CompareTo("css") == 0)
                    || (type.CompareTo("php") == 0)
                    || (type.CompareTo("js") == 0))
                {
                    ReadText();
                }
            }
        }

        private string getExtension(string s)
        {
        //Mengembalikan ekstensi file
            int z = s.Length - 1;
            while ((s.ElementAt(z) != '.') && (z > 0))
            {
                z--;
            }
            if (z == 0)
            {
                return null;
            }
            else
            {
                return s.Substring(z + 1);
            }
        }

        private void ReadText()
        {
        //Membaca file teks
            string result = "";
            //
            using (StreamReader sr = new System.IO.StreamReader(path))
            {
                string line;
                while (((line = sr.ReadLine()) != null))
                {
                    result += line;
                }
                text = result;
                
                //text = RemoveSpecialCharacters(result);
                    //Console.WriteLine(line);
            }
        }


        

        private void ReadDocx()
        {
        //Membaca file dengan format docx
            string packagePath = path;
            try
            {
                using (Package package = Package.Open(packagePath, FileMode.Open))
                {

                    PackagePart packagePart = package.GetPart(new Uri("/word/document.xml", UriKind.Relative));
                    Stream stream = packagePart.GetStream();
                    stream.Seek(0, SeekOrigin.Begin); // don't forget 
                    XmlDocument xmldoc = new XmlDocument();
                    xmldoc.PreserveWhitespace = true;
                    xmldoc.Load(stream);
                    text = xmldoc.DocumentElement.InnerText;
                }
            }
            catch (Exception e)
            {

            }
        }

        public string getText()
        {
        //Mengembalikan teks hasil pembacaan oleh FileReader
            return text;
        }
    }
}
