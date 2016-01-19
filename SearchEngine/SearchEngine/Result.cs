using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace SearchEngine
{
    class Result
    {
        private string title {get; set;}
        private string location { get; set; }
        private string excerpt { get; set; }
        public Result()
        {
        //konstruktor Result
        }

        public Result(string t, string l, string e)
        {
        //konstruktor Result dengan parameter untuk title, location, dan excerpt
            title = t;
            location = l;
            excerpt = e;
        }

        public string getTitle()
        {
        //mendapatkan title suatu Result
            return title;
        }
        public void setTitle(string s)
        {
            //mengeset title suatu Result
            title = s;
        }

        public string getLocation()
        {
        //mendapatkan title suatu Result
            return location;
        }
        private void setLocation(string s)
        {
        //mengeset location suatu Result
            location = s;
        }

        public string getExcerpt()
        {
        //mendapatkan excerpt suatu Result
            return excerpt;
        }
        public void setExcerpt(string s)
        {
        //mengeset excerpt suatu Result
            excerpt = s;
        }
        public void print()
        {
        //mencetak suatu Result
            Console.WriteLine("[Title]" + title +"[/Title]");
            Console.WriteLine("[Location]" + location + "[/Location]");
            Console.WriteLine("[Excerpt]" + excerpt + "[/Excerpt]");
        }

    }
}
