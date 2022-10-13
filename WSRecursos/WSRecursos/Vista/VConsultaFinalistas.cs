using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VConsultaFinalistas : BDconexion
    {
        public List<EConsultaFinalistas> ConsultaFinalistas()
        {
            List<EConsultaFinalistas> lCConsultaFinalistas = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CConsultaFinalistas oVConsultaFinalistas = new CConsultaFinalistas();
                    lCConsultaFinalistas = oVConsultaFinalistas.ConsultaFinalistas(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCConsultaFinalistas);
        }
    }
}