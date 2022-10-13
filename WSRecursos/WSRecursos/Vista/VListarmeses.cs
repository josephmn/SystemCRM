using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListarmeses : BDconexion
    {
        public List<EListarmeses> Listar_Listarmeses(Int32 post)
        {
            List<EListarmeses> lCListarmeses = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListarmeses oVListarmeses = new CListarmeses();
                    lCListarmeses = oVListarmeses.Listar_Listarmeses(con, post);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListarmeses);
        }
    }
}