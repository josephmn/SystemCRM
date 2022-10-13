using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VConsultarCronograma : BDconexion
    {
        public List<EConsultarCronograma> Listar_ConsultarCronograma(Int32 codigo)
        {
            List<EConsultarCronograma> lCConsultarCronograma = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CConsultarCronograma oVConsultarCronograma = new CConsultarCronograma();
                    lCConsultarCronograma = oVConsultarCronograma.Listar_ConsultarCronograma(con, codigo);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCConsultarCronograma);
        }
    }
}