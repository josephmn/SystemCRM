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
    public class CAsistencia
    {
        public List<EAsistencia> Listar_Asistencia(SqlConnection con, String finicio, String ffin)
        {
            List<EAsistencia> lEAsistencia = null;
            SqlCommand cmd = new SqlCommand("ASP_ASISTENCIA_DIARIA", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@finicio", SqlDbType.VarChar).Value = finicio;
            cmd.Parameters.AddWithValue("@ffin", SqlDbType.VarChar).Value = ffin;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEAsistencia = new List<EAsistencia>();

                EAsistencia obEAsistencia = null;
                while (drd.Read())
                {
                    obEAsistencia = new EAsistencia();
                    obEAsistencia.CODIGO = drd["CODIGO"].ToString();
                    obEAsistencia.DNI = drd["DNI"].ToString();
                    obEAsistencia.NOMBRE = drd["NOMBRE"].ToString();
                    obEAsistencia.AREA = drd["AREA"].ToString();
                    obEAsistencia.CARGO = drd["CARGO"].ToString();
                    obEAsistencia.ZONA = drd["ZONA"].ToString();
                    obEAsistencia.TIPO_ASISTENCIA = drd["TIPO_ASISTENCIA"].ToString();
                    obEAsistencia.DIA = drd["DIA"].ToString();
                    obEAsistencia.FECHA = drd["FECHA"].ToString();
                    obEAsistencia.ENTRADA = drd["ENTRADA"].ToString();
                    obEAsistencia.INI_REF = drd["INI_REF"].ToString();
                    obEAsistencia.TER_REF = drd["TER_REF"].ToString();
                    obEAsistencia.SALIDA = drd["SALIDA"].ToString();
                    obEAsistencia.COMENTARIO = drd["COMENTARIO"].ToString();
                    obEAsistencia.ASISTENCIA = drd["ASISTENCIA"].ToString();
                    obEAsistencia.REFRIGERIO = drd["REFRIGERIO"].ToString();
                    obEAsistencia.ASISTENCIA_COLOR = drd["ASISTENCIA_COLOR"].ToString();
                    obEAsistencia.REFRIGERIO_COLOR = drd["REFRIGERIO_COLOR"].ToString();
                    obEAsistencia.TEMP_ENT = drd["TEMP_ENT"].ToString();
                    obEAsistencia.TEMP_SAL = drd["TEMP_SAL"].ToString();
                    lEAsistencia.Add(obEAsistencia);
                }
                drd.Close();
            }

            return (lEAsistencia);
        }
    }
}