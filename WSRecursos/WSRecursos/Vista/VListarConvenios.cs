using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListarConvenios : BDconexion
    {
        public List<EListarConvenios> ListarConvenios(Int32 post, Int32 id)
        {
            List<EListarConvenios> lCListarConvenios = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListarConvenios oVListarConvenios = new CListarConvenios();
                    lCListarConvenios = oVListarConvenios.ListarConvenios(con, post, id);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListarConvenios);
        }
    }
}