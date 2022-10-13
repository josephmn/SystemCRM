using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Collections.Specialized;
using System.Linq;
using System.Web;
using System.Data;
using System.Data.SqlClient;
using WSRecursos.Entity;

namespace WSRecursos.Controller
{
    public class CListadoDocumentosPersonal
    {
        public List<EListadoDocumentosPersonal> Listar_ListadoDocumentosPersonal(SqlConnection con, String dni)
        {
            List<EListadoDocumentosPersonal> lEListadoDocumentosPersonal = null;
            SqlCommand cmd = new SqlCommand("ASP_LISTAR_DOCUMENTOS", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@dni", SqlDbType.VarChar).Value = dni;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListadoDocumentosPersonal = new List<EListadoDocumentosPersonal>();

                EListadoDocumentosPersonal obEListadoDocumentosPersonal = null;
                while (drd.Read())
                {
                    obEListadoDocumentosPersonal = new EListadoDocumentosPersonal();
                    obEListadoDocumentosPersonal.ID = drd["ID"].ToString();
                    obEListadoDocumentosPersonal.NOMBRE = drd["NOMBRE"].ToString();
                    obEListadoDocumentosPersonal.DIRECTORIO = drd["DIRECTORIO"].ToString();
                    obEListadoDocumentosPersonal.FECHA = drd["FECHA"].ToString();
                    obEListadoDocumentosPersonal.ICONO = drd["ICONO"].ToString();
                    obEListadoDocumentosPersonal.COLOR = drd["COLOR"].ToString();
                    lEListadoDocumentosPersonal.Add(obEListadoDocumentosPersonal);
                }
                drd.Close();
            }

            return (lEListadoDocumentosPersonal);
        }
    }
}