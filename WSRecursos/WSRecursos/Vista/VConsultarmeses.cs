using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VConsultarmeses : BDconexion
    {
        public List<EConsultarmeses> Listar_Consultarmeses(Int32 id)
        {
            List<EConsultarmeses> lCConsultarmeses = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CConsultarmeses oVConsultarmeses = new CConsultarmeses();
                    lCConsultarmeses = oVConsultarmeses.Listar_Consultarmeses(con, id);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCConsultarmeses);
        }
    }
}