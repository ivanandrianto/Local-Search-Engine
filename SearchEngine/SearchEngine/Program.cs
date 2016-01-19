using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace SearchEngine
{
    class Program
    {

        static void Main(string[] args)
        {
            string keyword = args[0];
            string path = args[1];
            string type = args[2];

            Explorer e = new Explorer(path, keyword, type);
            Console.WriteLine(e.getTreeString());
            
        }
    }
}
